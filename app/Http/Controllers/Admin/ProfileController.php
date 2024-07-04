<?php

namespace App\Http\Controllers\Admin;

use App\Rules\CheckOldPassword;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ApiResponses;
    public function update(Request $request)
    {
        if ($request->image) {
            if (auth()->user()->hasImage()) {
                Storage::disk('public')->delete('users/' . auth()->user()->image);
            }
            $request->image->store('users', 'public');
            $request['updated_image'] = $request->image->hashName();
        }

        auth()->user()->update([
            'name' => $request->name ?? auth()->user()->name,
            'email' => $request->email ?? auth()->user()->email,
            'image' => $request->has('updated_image') ? $request->updated_image : auth()->user()->image
        ]);

        return $this->successResponse(['message' => 'Profile updated successfully']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new CheckOldPassword],
            'password' => 'required|confirmed|min:8',
        ]);

        $request->merge(['password' => bcrypt($request->password)]);

        auth()->user()->update([
            'password' => $request->password,
        ]);

        return $this->successResponse(['message' => 'Password updated successfully']);
    }
}