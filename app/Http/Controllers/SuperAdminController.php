<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
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
            ->latest('short_urls.created_at')
            ->get();

        return view('superadmin.dashboard', compact('companies', 'urls'));
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

    public function companies()
    {
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
            ->paginate(2);

        return view('superadmin.companies', compact('companies'));
    }

    public function urls()
    {
        $urls = ShortUrl::join('companies', 'short_urls.company_id', '=', 'companies.cid')
            ->select(
                'short_urls.*',
                'companies.name as company_name'
            )
            ->latest('short_urls.created_at')
            ->paginate(2);

        return view('superadmin.urls', compact('urls'));
    }
}
