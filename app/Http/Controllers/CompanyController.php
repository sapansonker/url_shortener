<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->get();
        return view('superadmin.dashboard', compact('companies'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|max:255',
            'admin_name'   => 'required|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
        ]);

        $company = Company::create([
            'name' => $request->company_name,
        ]);

        User::create([
            'company_id' => $company->id,
            'name'       => $request->admin_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => UserRole::ADMIN->value,
        ]);

        return redirect()
            ->route('superadmin.dashboard')
            ->with('success', 'Company and Admin created successfully.');
    }
}
