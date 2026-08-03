<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        // Get all settings from DB as an associative array: ['key' => 'value']
        $settings = Setting::pluck('value', 'key')->toArray();
        
        return view('admin.settings.page', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        // Validate request
        $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string'
        ]);

        $settings = $request->input('settings');
        
        // Checkboxes that are unchecked won't be sent in the request,
        // so we can't just blindly loop through the request data if we want to handle booleans.
        // However, if we structure the form inputs specifically or just process what we receive,
        // we can handle toggles with hidden inputs (e.g. <input type="hidden" name="settings[maintenance_mode]" value="0"> before the checkbox).
        
        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
