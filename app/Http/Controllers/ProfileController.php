<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $image = $profile->image ?? '';
        return view("profile.index", compact("user", "profile","image"));
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
    public function storeOrUpdate(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:profiles,email,' . ($profile ? $profile->id : 'NULL'),
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:8048',
        ]);

        $imageName = '';

        if ($request->hasFile('image')) {
            // Delete previous image if it exists
            if ($profile && $profile->image) {
                $previousImage = public_path('profile_imgs/') . $profile->image;
                if (file_exists($previousImage)) {
                    unlink($previousImage);
                }
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('profile_imgs'), $imageName);
        }



        if ($profile) {
            $profile->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'image' => $imageName,


            ]);
        } else {
            $profile = Profile::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'image' => $imageName,
            ]);
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }


}