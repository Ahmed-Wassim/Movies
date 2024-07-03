<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->with(['roles' => fn ($query) => $query->select('id', 'name')])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('user');

        return $this->createdResponse([$user, 'User created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->with(['roles' => fn ($query) => $query->select('id', 'name')])->get();

        if ($user->isEmpty()) {
            return $this->notFoundResponse('User not found');
        }

        return $this->successResponse($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $user->update([
            'name' => $request->name,
            'email' => $request->email ?? $user->email,
        ]);

        return $this->noContentResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->first();


        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        // dd($admin);

        $user->removeRole('admin');
        $user->delete();

        return $this->okResponse($user);
    }

    public function bulkDelete(Request $request)
    {
        $userIds = $request->user_ids; // Replace with your array of user IDs

        $users = User::whereIn('id', $userIds)->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        if ($users->isEmpty()) {
            return $this->notFoundResponse('Users not found');
        }

        foreach ($users as $user) {
            $user->removeRole('user');
            $user->delete();
        }

        return $this->okResponse('Users removed successfully');
    }
}
