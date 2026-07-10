<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use App\Enums\UserRole;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShortUrlController extends Controller
{
    public function index()
    {
        $query = ShortUrl::query();

        if (auth()->user()->role === UserRole::ADMIN->value) {
            $query->where('company_id', auth()->user()->company_id);
        } else {
            $query->where('user_id', auth()->id());
        }

        $urls = $query->latest()->get();
        return view('urls.index', compact('urls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        do {
            $code = Str::random(6);
        } while (ShortUrl::where('short_code', $code)->exists());

        ShortUrl::create([
            'company_id' => auth()->user()->company_id,
            'user_id' => auth()->id(),
            'original_url' => $request->original_url,
            'short_code' => $code,
        ]);

        (auth()->user()->role === UserRole::ADMIN->value)
            ? $returnRoute = 'admin.dashboard'
            : $returnRoute = 'member.dashboard';

        return redirect()
            ->route($returnRoute)
            ->with('success', 'Short URL created successfully.');
    }

    public function redirect($code)
    {
        $url = ShortUrl::where('short_code', $code)->firstOrFail();

        $url->increment('hits');

        return redirect()->away($url->original_url);
    }

    public function download(Request $request): StreamedResponse
    {
        $dateRange = $request->query('date_range');
        $query = ShortUrl::query();

        if (auth()->user()->role === UserRole::ADMIN->value) {

            $query->where('short_urls.company_id', auth()->user()->company_id)
                ->join('users', 'short_urls.user_id', '=', 'users.id')
                ->select(
                    'short_urls.*',
                    'users.name as user_name'
                );
        } 
        elseif (auth()->user()->role === UserRole::SUPER_ADMIN->value) {
            $query = ShortUrl::join('companies', 'short_urls.company_id', '=', 'companies.cid')
                ->select(
                    'short_urls.*',
                    'companies.name as company_name'
                )
                ->latest('short_urls.created_at');
        } 
        else {
            $query->where('short_urls.user_id', auth()->id())
                ->join('users', 'short_urls.user_id', '=', 'users.id')
                ->select(
                    'short_urls.*',
                    'users.name as user_name'
                );
        }

        if ($dateRange === 'today') {
            $query->whereDate('short_urls.created_at', Carbon::today());
        } elseif ($dateRange === 'last_week') {
            $query->whereBetween('short_urls.created_at', [Carbon::now()->subWeek()->startOfDay(), Carbon::now()->endOfDay()]);
        } elseif ($dateRange === 'last_month') {
            $query->whereBetween('short_urls.created_at', [Carbon::now()->subMonth()->startOfDay(), Carbon::now()->endOfDay()]);
        }

        $urls = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->streamDownload(function () use ($urls) {

            $file = fopen('php://output', 'w');

            if (auth()->user()->role === UserRole::SUPER_ADMIN->value) {
                fputcsv($file, [
                    'Short URL',
                    'Long URL',
                    'Hits',
                    'Company Name',
                    'Created On'
                ]);

                foreach ($urls as $url) {
                    fputcsv($file, [
                        url('/s/' . $url->short_code),
                        $url->original_url,
                        $url->hits,
                        $url->company_name,
                        $url->created_at,
                    ]);
                }
            } else {
                fputcsv($file, [
                    'Short URL',
                    'Original URL',
                    'Hits',
                    'User',
                    'Created On'
                ]);

                foreach ($urls as $url) {
                    fputcsv($file, [
                        url('/s/' . $url->short_code),
                        $url->original_url,
                        $url->hits,
                        $url->user_name,
                        $url->created_at,
                    ]);
                }
            }

            fclose($file);
        }, 'generated_urls.csv', $headers);
    }
}
