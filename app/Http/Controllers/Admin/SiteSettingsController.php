<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    /**
     * Display the site settings form.
     */
    public function edit()
    {
        // Group settings by their group
        $settingGroups = [
            'general' => Setting::where('group', 'general')->get(),
            'creator' => Setting::where('group', 'creator')->get(),
            'social' => Setting::where('group', 'social')->get(),
            'seo' => Setting::where('group', 'seo')->get(),
        ];
        
        return view('admin.settings.edit', compact('settingGroups'));
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            // For file uploads
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('settings', 'public');
                
                // If there was a previous file, delete it
                $setting = Setting::where('key', $key)->first();
                if ($setting && $setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }
                
                $value = $path;
            }
            
            // Determine the group based on the key prefix
            $group = 'general';
            if (str_starts_with($key, 'creator_')) {
                $group = 'creator';
            } elseif (str_starts_with($key, 'social_')) {
                $group = 'social';
            } elseif (str_starts_with($key, 'seo_')) {
                $group = 'seo';
            }
            
            // Determine the type based on the value
            $type = 'text';
            if (is_bool($value)) {
                $type = 'boolean';
            } elseif (is_numeric($value)) {
                $type = 'number';
            } elseif (filter_var($value, FILTER_VALIDATE_URL)) {
                $type = 'url';
            } elseif (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $type = 'email';
            } elseif (str_contains($value, 'storage/settings/')) {
                $type = 'image';
            } elseif (strlen($value) > 255) {
                $type = 'textarea';
            }
            
            Setting::set($key, $value, $group, $type);
        }
        
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
