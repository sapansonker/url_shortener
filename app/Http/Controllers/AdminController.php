<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $members = User::where('users.company_id', auth()->user()->company_id)
            ->leftJoin('short_urls', 'users.id', '=', 'short_urls.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.role',
                DB::raw('COUNT(short_urls.id) as total_urls'),
                DB::raw('COALESCE(SUM(short_urls.hits), 0) as total_hits')
            )
            ->groupBy(
                'users.id',
                'users.name',
                'users.email',
                'users.role'
            )
            ->get();

        $urls = ShortUrl::where('short_urls.company_id', auth()->user()->company_id)
            ->join('users', 'short_urls.user_id', '=', 'users.id')
            ->select(
                'short_urls.*',
                'users.name as user_name'
            )
            ->latest('short_urls.created_at')
            ->get();

        return view('admin.dashboard', compact('members', 'urls'));
    }

    public function urls()
    {
        $urls = ShortUrl::where('short_urls.company_id', auth()->user()->company_id)
            ->join('users', 'short_urls.user_id', '=', 'users.id')
            ->select(
                'short_urls.*',
                'users.name as user_name'
            )
            ->latest('short_urls.created_at')
            ->paginate(2);

        return view('admin.urls', compact('urls'));
    }

    public function createUrl()
    {
        return view('admin.create-url');
    }

    public function members()
    {
        $members = User::where('users.company_id', auth()->user()->company_id)
            ->leftJoin('short_urls', 'users.id', '=', 'short_urls.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.role',
                DB::raw('COUNT(short_urls.id) as total_urls'),
                DB::raw('COALESCE(SUM(short_urls.hits), 0) as total_hits')
            )
            ->groupBy(
                'users.id',
                'users.name',
                'users.email',
                'users.role'
            )
            ->paginate(2);

        return view('admin.members', compact('members'));
    }

    public function createMember()
    {
        return view('admin.create-member');
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:member,admin',
        ]);

        $user = new User();
        $user->company_id = auth()->user()->company_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

        if ($user->save()) {
            $message = 'Member created successfully.';
        } else {
            $message = 'Failed to create member. Please try again.';
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', $message);
    }
}
