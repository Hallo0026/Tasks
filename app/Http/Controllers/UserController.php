<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function getPreferences()
    {
        $user = Auth::user();
        return response()->json($user->preferences);
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $preferences = $request->validate([
            'theme' => 'in:light,dark',
            'sidebar_expanded' => 'boolean',
        ]);

        $user->preferences = array_merge((array) $user->preferences, $preferences);

        $user = new User;
        $user->save();

        return response()->json(['message' => 'Preferences updated successfully.']);
    }

    public function getProfilePicture()
    {
        $user = Auth::user();
        return response()->json($user->profile_picture);
    }

}
