<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    /**
     * Tampilkan daftar pengguna.
     */
    public function index(Request $request)
    {
        $query = User::latest();

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10);
        $totalUsers = User::count();

        return view('admin.pengguna', compact('users', 'totalUsers'));
    }
}
