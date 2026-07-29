<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a new contact message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|regex:/^[0-9]{1,20}$/',
            'country' => 'nullable|string|max:100',
            'subject' => 'required|string|max:500',
            'message' => 'required|string|min:10',
        ]);

        try {
            $contactMessage = ContactMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'country' => $validated['country'] ?? null,
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => ContactMessage::STATUS_NEW,
            ]);

            // Send email notification to support team
            try {
                $supportEmail = env('SUPPORT_EMAIL', 'ss9819690@gmail.com');
                \Mail::to($supportEmail)->send(new \App\Mail\ContactFormNotification($contactMessage));
            } catch (\Exception $e) {
                // Log the error but don't fail the submission
                \Log::warning('Failed to send contact form notification email: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting us! We will get back to you soon.',
                'data' => [
                    'id' => $contactMessage->id
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error submitting your message. Please try again later.'
            ], 500);
        }
    }
}
