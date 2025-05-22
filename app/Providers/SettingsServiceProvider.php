<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Default to an empty collection if checks fail
        $settings = collect();

        // Only attempt to load settings if not in console OR if table exists
        if (!app()->runningInConsole() && Schema::hasTable('settings')) {
            try {
                $settings = Cache::remember('settings', 600, function () {
                    // Check again inside cache closure just in case
                    if (!Schema::hasTable('settings')) {
                        return collect();
                    }
                    return Setting::all()->keyBy('key');
                });
            } catch (QueryException $e) {
                // Handle potential query errors, return empty collection
                // Log::error('Error loading settings in SettingsServiceProvider: ' . $e->getMessage());
                $settings = collect(); 
            } catch (\Exception $e) {
                // Catch any other unexpected errors
                // Log::error('Unexpected error loading settings: ' . $e->getMessage());
                $settings = collect(); 
            }
        } elseif (app()->runningInConsole() && Schema::hasTable('settings')) {
            // If in console BUT the table *does* exist (e.g., a command running *after* migrate)
            // attempt to load from DB (consider if needed, could just return default)
            try {
                 $settings = Setting::all()->keyBy('key'); // Maybe cache this too
            } catch (QueryException $e) {
                 $settings = collect();
            } catch (\Exception $e) {
                 $settings = collect(); 
            }
        } 
        // If app()->runningInConsole() is true AND Schema::hasTable('settings') is false,
        // we do nothing and $settings remains an empty collection.

        // Share settings with all views (will be empty collection if loading failed)
        View::share('settings', $settings ?? collect());
    }
} 