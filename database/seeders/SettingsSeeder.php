<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General website settings
        $generalSettings = [
            'site_name' => 'Creator Showcase',
            'site_description' => 'Discover impressive digital products from talented creators.',
            'contact_email' => 'contact@example.com',
            'footer_text' => '© ' . date('Y') . ' Creator Showcase. All rights reserved.',
        ];
        
        foreach ($generalSettings as $key => $value) {
            Setting::set($key, $value, 'general');
        }
        
        // Creator profile placeholder settings
        $creatorSettings = [
            'creator_tagline' => 'Showcasing the best digital products',
            'creator_intro' => 'This platform features talented creators and their impressive digital products.',
            'about_creators' => 'Our creators are passionate about building high-quality digital products that solve real problems.',
        ];
        
        foreach ($creatorSettings as $key => $value) {
            Setting::set($key, $value, 'creator');
        }
        
        // Social media settings
        $socialSettings = [
            'social_twitter' => 'https://twitter.com/example',
            'social_facebook' => 'https://facebook.com/example',
            'social_instagram' => 'https://instagram.com/example',
            'social_github' => 'https://github.com/example',
        ];
        
        foreach ($socialSettings as $key => $value) {
            Setting::set($key, $value, 'social', 'url');
        }
        
        // SEO settings
        $seoSettings = [
            'seo_title' => 'Creator Showcase | Digital Products',
            'seo_description' => 'Discover impressive digital products from talented creators. Browse and explore the best in the business.',
            'seo_keywords' => 'digital products, creator, showcase, portfolio',
            'seo_og_image' => '',
        ];
        
        foreach ($seoSettings as $key => $value) {
            Setting::set($key, $value, 'seo');
        }
    }
}
