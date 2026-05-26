<?php

namespace App\Http\Controllers\admin;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/user/User', [
            'positions' => Position::all(),
            'roles' => ['admin', 'manager', 'member'],

            'users' => User::query()
                ->when($request->search, function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->when($request->position, function($query) use ($request) {
                    $query->where('position', $request->position);
                })
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|',
            'role' => 'required|in:admin,manager,member',
            'position' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'position' => $validated['position'],
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|',
            'role' => 'required|in:admin,manager,member',
            'position' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'position' => $validated['position'],
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
