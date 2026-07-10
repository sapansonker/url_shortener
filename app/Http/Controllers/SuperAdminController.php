<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuperAdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $dateRange = $request->query('date_range');

        $companies = Company::select(
                'companies.*'
            )
            ->selectSub(function ($query) {
                $query->from('users')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('users.company_id', 'companies.cid');
            }, 'total_users')
            ->selectSub(function ($query) {
                $query->from('short_urls')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('short_urls.company_id', 'companies.cid');
            }, 'total_urls')
            ->selectSub(function ($query) {
                $query->from('short_urls')
                    ->selectRaw('COALESCE(SUM(hits), 0)')
                    ->whereColumn('short_urls.company_id', 'companies.cid');
            }, 'total_hits')
            ->get();

        $urls = ShortUrl::join('companies', 'short_urls.company_id', '=', 'companies.cid')
            ->select(
                'short_urls.*',
                'companies.name as company_name'
            )
            ->latest('short_urls.created_at');

        if ($dateRange === 'today') {
            $urls->whereDate('short_urls.created_at', Carbon::today());
        } elseif ($dateRange === 'last_week') {
            $urls->whereBetween('short_urls.created_at', [Carbon::now()->subWeek()->startOfDay(), Carbon::now()->endOfDay()]);
        } elseif ($dateRange === 'last_month') {
            $urls->whereBetween('short_urls.created_at', [Carbon::now()->subMonth()->startOfDay(), Carbon::now()->endOfDay()]);
        }

        $urls = $urls->get();

        return view('superadmin.dashboard', compact('companies', 'urls', 'dateRange'));
    }

    public function createCompany()
    {
        return view('superadmin.create-company');
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'admin_name'   => 'required|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
        ]);

        $cid = "CID" . strtoupper(uniqid()); // Generate a unique company ID

        $company = new Company();
        $company->cid = $cid;
        $company->name = $request->company_name;
        
        if ($company->save()) {
            $user = new User();
            $user->company_id = $cid;
            $user->name = $request->admin_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = UserRole::ADMIN->value;
            
            if ($user->save()) {
                $message = 'Company and Admin created successfully.';
            } else {
                $message = 'Failed to create admin user. Please try again.';
            }
        } else {
            $message = 'Failed to create company. Please try again.';
        }

        return redirect()
            ->route('superadmin.dashboard')
            ->with('success', $message);
    }

    public function companies(Request $request)
    {
        $dateRange = $request->query('date_range');

        $companies = Company::select(
                'companies.*'
            )
            ->selectSub(function ($query) {
                $query->from('users')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('users.company_id', 'companies.cid');
            }, 'total_users')
            ->selectSub(function ($query) {
                $query->from('short_urls')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('short_urls.company_id', 'companies.cid');
            }, 'total_urls')
            ->selectSub(function ($query) {
                $query->from('short_urls')
                    ->selectRaw('COALESCE(SUM(hits), 0)')
                    ->whereColumn('short_urls.company_id', 'companies.cid');
            }, 'total_hits');

        if ($dateRange === 'today') {
            $companies->whereDate('companies.created_at', Carbon::today());
        } elseif ($dateRange === 'last_week') {
            $companies->whereBetween('companies.created_at', [Carbon::now()->subWeek()->startOfDay(), Carbon::now()->endOfDay()]);
        } elseif ($dateRange === 'last_month') {
            $companies->whereBetween('companies.created_at', [Carbon::now()->subMonth()->startOfDay(), Carbon::now()->endOfDay()]);
        }

        $companies = $companies->paginate(2)->withQueryString();

        return view('superadmin.companies', compact('companies', 'dateRange'));
    }

    public function urls(Request $request)
    {
        $dateRange = $request->query('date_range');

        $urls = ShortUrl::join('companies', 'short_urls.company_id', '=', 'companies.cid')
            ->select(
                'short_urls.*',
                'companies.name as company_name'
            )
            ->latest('short_urls.created_at');

        if ($dateRange === 'today') {
            $urls->whereDate('short_urls.created_at', Carbon::today());
        } elseif ($dateRange === 'last_week') {
            $urls->whereBetween('short_urls.created_at', [Carbon::now()->subWeek()->startOfDay(), Carbon::now()->endOfDay()]);
        } elseif ($dateRange === 'last_month') {
            $urls->whereBetween('short_urls.created_at', [Carbon::now()->subMonth()->startOfDay(), Carbon::now()->endOfDay()]);
        }

        $urls = $urls->paginate(2)->withQueryString();

        return view('superadmin.urls', compact('urls', 'dateRange'));
    }
}
