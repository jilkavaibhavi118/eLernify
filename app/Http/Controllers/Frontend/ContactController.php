<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $message = ContactMessage::create($request->all());

        // Notify Admins
        try {
            $admins = \App\Models\User::role('Admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\NewContactMessageNotification($message));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Admin Contact Notification Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
