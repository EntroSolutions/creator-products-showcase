<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

if (!function_exists('setting')) {
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        // ABSOLUTE DEFENSE: Prevent DB queries during ANY console command execution.
        // If settings *are* needed for a specific command, that command must handle
        // loading them itself after the framework/DB is fully booted, or use caching.
        if (app()->runningInConsole()) {
            return $default;
        }

        // For web requests, still check if the table exists before querying.
        if (!Schema::hasTable('settings')) {
           return $default;
        }
        
        // If we got past the initial checks (i.e., it's a web request and table exists)
        try {
            // Consider caching this query for performance
            // Example: return Cache::rememberForever("settings.{$key}", function () use ($key, $default) {
            //     $setting = Setting::where('key', $key)->first();
            //     return $setting ? $setting->value : $default;
            // });
            
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        } catch (QueryException $e) {
            // Handle potential query errors (e.g., table just created but not fully available)
            // Log the error if needed: Log::error("Error fetching setting '$key': ". $e->getMessage());
            return $default;
        } catch (\Exception $e) {
            // Catch any other unexpected errors
            // Log::error("Unexpected error fetching setting '$key': ". $e->getMessage());
            return $default;
        }
    }
} 