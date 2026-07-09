<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
    ];

    public function index()
    {
        $companies = Company::all();
        return view('superadmin.dashboard', compact('companies'));
    }
}
