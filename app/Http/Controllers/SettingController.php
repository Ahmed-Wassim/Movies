<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $settings = [
            'logo' => asset('storage/settings/' . setting('logo')),
            'fav_icon' => asset('storage/settings/' . setting('fav_icon')),
            'title' => setting('title'),
            'description' => setting('description'),
            'keywords' => setting('keywords'),
            'email' => setting('email'),
            'phone' => setting('phone'),
        ];

        return $this->successResponse($settings);
    }

    public function update(Request $request)
    {
        //logo - fav-icon - title - description - keywords - email - phone
        if ($request->has('logo')) {
            Storage::disk('public')->delete('settings/' . setting('logo'));
            $request->logo->store('settings', 'public');
            $request['updated_logo'] = $request->logo->hashName();
        }

        if ($request->has('fav_icon')) {
            Storage::disk('public')->delete('settings/' . setting('fav_icon'));
            $request->fav_icon->store('settings', 'public');
            $request['updated_fav_icon'] = $request->file('fav_icon')->hashName();
        }

        setting([
            'logo' => $request->has('updated_logo') ? $request->updated_logo : setting('logo'),
            'fav_icon' => $request->has('updated_fav_icon') ? $request->updated_fav_icon : setting('fav_icon'),
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'email' => $request->email,
            'phone' => $request->phone,
        ])->save();

        return $this->noContentResponse();
    }
}