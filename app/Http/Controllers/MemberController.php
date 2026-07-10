<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function dashboard(Request $request)
    {
        $dateRange = $request->query('date_range');

        $urls = ShortUrl::where('user_id', auth()->id())
            ->latest('short_urls.created_at');

        if ($dateRange === 'today') {
            $urls->whereDate('short_urls.created_at', Carbon::today());
        } elseif ($dateRange === 'last_week') {
            $urls->whereBetween('short_urls.created_at', [Carbon::now()->subWeek()->startOfDay(), Carbon::now()->endOfDay()]);
        } elseif ($dateRange === 'last_month') {
            $urls->whereBetween('short_urls.created_at', [Carbon::now()->subMonth()->startOfDay(), Carbon::now()->endOfDay()]);
        }

        $urls = $urls->paginate(2)->withQueryString();

        return view('member.dashboard', compact('urls', 'dateRange'));
    }

    public function createUrl()
    {
        return view('member.create-url');
    }
}
