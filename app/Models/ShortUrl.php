<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $fillable = [
        'company_id',
        'user_id',
        'original_url',
        'short_code',
        'hits',
    ];
    
    public function dashboard()
    {
        $members = User::where('company_id', auth()->user()->company_id)
            ->where('role', UserRole::MEMBER->value)
            ->get();

        $urls = ShortUrl::where('company_id', auth()->user()->company_id)
            ->latest()
            ->get();

        return view('admin.dashboard', compact('members', 'urls'));
    }
}
