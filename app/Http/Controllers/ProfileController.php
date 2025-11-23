<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('profile');
        return view('settings.index', compact('user'));
    }


    public function edit()
    {
        $user = Auth::user()->load('profile');
        
        return view('settings.edit_settings', compact('user'));
    }

    public function updateGeneral(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'language' => 'required|string|max:50',
            'currency' => 'required|string|max:10',
            'theme' => 'required|string|max:50',
            'profile_photo' => 'nullable|image|max:2048',
            'remove_profile_photo' => 'nullable|boolean',
        ]);

        // Update User Model
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Prepare Profile Data
        $profileData = $validated;
        unset($profileData['name'], $profileData['email']);

        // Photo Upload Logic
        $profilePhotoPath = $user->profile->profile_photo_path ?? null;

        if ($request->input('remove_profile_photo')) {
            if ($profilePhotoPath) {
                Storage::disk('public')->delete($profilePhotoPath);
            }
            $profilePhotoPath = null;
        } elseif ($request->hasFile('profile_photo')) {
            if ($profilePhotoPath) {
                Storage::disk('public')->delete($profilePhotoPath);
            }
            $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $profileData['profile_photo_path'] = $profilePhotoPath;
        if (isset($profileData['remove_profile_photo'])) {
            unset($profileData['remove_profile_photo']);
        }

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('profile.edit', ['#' => 'general'])->with('status', 'General settings updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $settings = $user->settings ?? []; 
        
        $settings['notifications']['email'] = $request->boolean('email_notifications');
        $settings['notifications']['sms'] = $request->boolean('sms_notifications');
        
        $user->settings = $settings;
        $user->save();

        return redirect()->route('profile.edit', ['#' => 'notifications'])->with('status', 'Notification settings updated successfully.');
    }

    public function updateSecurity(Request $request)
    {
         $user = Auth::user();
         
         $validated = $request->validate([
             'current_password' => 'required|current_password', 
             'new_password' => ['required', 'string', Password::min(8), 'confirmed'],
         ]);

         $user->password = Hash::make($validated['new_password']);
         $user->save();

         return redirect()->route('profile.edit', ['#' => 'security'])->with('status', 'Password updated successfully.');
    }
}