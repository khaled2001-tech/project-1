<?php

namespace App\Http\Controllers;

use App\Models\Setteing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

// في SettingsController.php

public function create()
{
    return view('back.setteings.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'about' => 'required|string',
    ]);

    if ($request->hasFile('logo')) {
        $validated['logo'] = $request->file('logo')->store('settings', 'public');
    }

   Setteing::create($validated);

    return redirect()->route('settings.show')
        ->with('success', 'تم إضافة الإعدادات بنجاح');
}
    public function show()
    {
        $setting =  Setteing::first();


        return view('back.setteings.show', compact('setting'));
    }

    public function edit($id)
    {
        $setting = Setteing::findOrFail($id);
        return view('back.setteings.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = Setteing::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'required|string|max:5000'
        ]);

        // رفع الشعار إذا تم اختياره
        if ($request->hasFile('logo')) {
            // حذف الشعار القديم
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $setting->update($validated);

        return redirect()->route('settings.show')
                        ->with('success', 'Settings updated successfully!');
    }
}
