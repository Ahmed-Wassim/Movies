<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  User::whereHas('roles', function ($query) {
            $query->where('name', 'admin')
                ->orWhere('name', 'super_admin');
        })->with(['roles' => fn ($query) => $query->select('id', 'name')])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => bcrypt($request->password),
        ]);

        $admin->assignRole('admin');

        return $this->createdResponse([$admin, 'Admin created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::where('id', $id)->whereHas('roles', function ($query) {
            $query->where('name', 'admin')
                ->orWhere('name', 'super_admin');
        })->with(['roles' => fn ($query) => $query->select('id', 'name')])->get();

        if ($admin->isEmpty()) {
            return $this->notFoundResponse('Admin not found');
        }

        return $this->successResponse($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {

        $admin->update([
            'name' => $request->name,
            'email' => $request->email ?? $admin->email,
        ]);

        return $this->noContentResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::where('id', $id)->whereHas('roles', function ($query) {
            $query->where('name', 'admin')
                ->orWhere('name', 'super_admin');
        })->first();


        if (!$admin) {
            return $this->notFoundResponse('Admin not found');
        }

        // dd($admin);

        $admin->removeRole('admin');
        $admin->delete();

        return $this->okResponse($admin);
    }
}
