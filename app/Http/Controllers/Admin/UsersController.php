<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class UsersController extends Controller
{
    public function view(): Response
    {
        $users = User::paginate(10); // Tambahkan ini untuk load users awal

        return Inertia::render("Admin/User", [
            'users' => $users, // Pass users ke view
        ]);
    }

    // Hapus method index yang lama dan ganti dengan ini
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where("name", "LIKE", "%{$request->search}%")
                  ->orWhere('email', 'LIKE', "%{$request->search}%")
                  ->orWhere('phone', 'LIKE', "%{$request->search}%");
            });
        }

        $users = $query->paginate(10);

        return response()->json($users);
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|unique:users,phone,' . $id,
            'roles' => 'required|array',
            'is_Banned' => 'boolean'
        ]);

        $user->update($validated);

        return redirect()->back()->with('message', 'User updated successfully');
    }
}
