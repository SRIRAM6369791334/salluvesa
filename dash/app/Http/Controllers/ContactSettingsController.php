<?php

namespace App\Http\Controllers;

use App\Models\ContactSetting;
use Illuminate\Http\Request;

class ContactSettingsController extends Controller
{
    /**
     * Display contact settings page (Read).
     */
    public function index()
    {
        $contactSetting = ContactSetting::firstOrCreate(
            ['id' => 1],
            [
                'store_address' => "452 15h Street, Office 741, Ohio,\nDe 47754, USA",
                'email_address' => "info@saaluvesa.com",
                'phone_number'  => "+91 9655482775",
            ]
        );

        return view('pages.contact_settings', compact('contactSetting'));
    }

    /**
     * Update contact settings in database (Update).
     */
    public function update(Request $request)
    {
        // Validation rules & character limits
        $request->validate([
            'store_address' => 'required|string|min:5|max:500',
            'email_address' => 'required|email|max:255',
            'phone_number'  => 'required|string|min:7|max:50',
        ], [
            'store_address.required' => 'Store address is required.',
            'store_address.max'      => 'Store address cannot exceed 500 characters.',
            'email_address.required' => 'Email address is required.',
            'email_address.email'    => 'Please enter a valid email address.',
            'email_address.max'      => 'Email address cannot exceed 255 characters.',
            'phone_number.required'  => 'Phone number is required.',
            'phone_number.max'       => 'Phone number cannot exceed 50 characters.',
        ]);

        $contactSetting = ContactSetting::firstOrCreate(['id' => 1]);
        $contactSetting->update([
            'store_address' => $request->store_address,
            'email_address' => $request->email_address,
            'phone_number'  => $request->phone_number,
        ]);

        return redirect()->back()->with('success', 'Contact details updated successfully!');
    }
}
