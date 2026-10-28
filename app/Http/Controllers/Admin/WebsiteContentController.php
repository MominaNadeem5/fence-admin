<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WebsiteContentController extends Controller
{
    public function edit()
    {
        $settings = DB::table('home_page_settings')->first();

        return view('admin.website-content', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = DB::table('home_page_settings')->first();

        if (! $settings) {
            abort(500, 'Website settings record was not found.');
        }

        $data = $request->validate([
            'brand_name' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string', 'max:255'],

            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:1000'],

            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,webp', 'max:1024'],

            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string'],

            'hero_primary_button_text' => ['nullable', 'string', 'max:255'],
            'hero_primary_button_url' => ['nullable', 'string', 'max:2048'],
            'hero_secondary_button_text' => ['nullable', 'string', 'max:255'],
            'hero_secondary_button_url' => ['nullable', 'string', 'max:2048'],

            'stat_1_value' => ['nullable', 'string', 'max:100'],
            'stat_1_label' => ['nullable', 'string', 'max:255'],
            'stat_2_value' => ['nullable', 'string', 'max:100'],
            'stat_2_label' => ['nullable', 'string', 'max:255'],
            'stat_3_value' => ['nullable', 'string', 'max:100'],
            'stat_3_label' => ['nullable', 'string', 'max:255'],

            'about_title' => ['required', 'string', 'max:255'],
            'about_text' => ['required', 'string'],

            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $updates = [
            'brand_name' => $data['brand_name'],
            'tagline' => $data['tagline'],

            'seo_title' => $data['seo_title'] ?? null,
            'seo_description' => $data['seo_description'] ?? null,

            'hero_title' => $data['hero_title'],
            'hero_subtitle' => $data['hero_subtitle'],

            'hero_primary_button_text' => $data['hero_primary_button_text'] ?? null,
            'hero_primary_button_url' => $data['hero_primary_button_url'] ?? null,
            'hero_secondary_button_text' => $data['hero_secondary_button_text'] ?? null,
            'hero_secondary_button_url' => $data['hero_secondary_button_url'] ?? null,

            'stat_1_value' => $data['stat_1_value'] ?? null,
            'stat_1_label' => $data['stat_1_label'] ?? null,
            'stat_2_value' => $data['stat_2_value'] ?? null,
            'stat_2_label' => $data['stat_2_label'] ?? null,
            'stat_3_value' => $data['stat_3_value'] ?? null,
            'stat_3_label' => $data['stat_3_label'] ?? null,

            'about_title' => $data['about_title'],
            'about_text' => $data['about_text'],

            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,

            'updated_at' => now(),
        ];

        $oldLogo = $settings->logo_path;
        $oldFavicon = $settings->favicon_path;
        $oldHeroImage = $settings->hero_image_path;

        if ($request->hasFile('logo')) {
            $updates['logo_path'] = $request->file('logo')
                ->store('branding', 'public');
        }

        if ($request->hasFile('favicon')) {
            $updates['favicon_path'] = $request->file('favicon')
                ->store('branding', 'public');
        }

        if ($request->hasFile('hero_image')) {
            $updates['hero_image_path'] = $request->file('hero_image')
                ->store('branding', 'public');
        }

        DB::table('home_page_settings')
            ->where('id', $settings->id)
            ->update($updates);

        // Delete old files after the database update succeeds.
        if (isset($updates['logo_path']) && $oldLogo) {
            Storage::disk('public')->delete($oldLogo);
        }

        if (isset($updates['favicon_path']) && $oldFavicon) {
            Storage::disk('public')->delete($oldFavicon);
        }

        if (isset($updates['hero_image_path']) && $oldHeroImage) {
            Storage::disk('public')->delete($oldHeroImage);
        }

        return redirect()
            ->route('admin.website-content.edit')
            ->with('success', 'Website content successfully updated!');
    }
}
