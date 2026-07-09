<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;

class MemberController extends Controller
{
    public function dashboard()
    {
        $urls = ShortUrl::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('member.dashboard', compact('urls'));
    }
}
