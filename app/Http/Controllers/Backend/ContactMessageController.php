<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContactMessage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = ContactMessage::query()->latest();
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('status', function ($row) {
                        return $row->status == 'replied'
                            ? '<span class="badge bg-success">Replied</span>'
                            : '<span class="badge bg-warning text-dark">Pending</span>';
                    })
                    ->addColumn('action', function($row){
                        return view('layouts.includes.list-actions', [
                            'module' => 'contact_messages',
                            'routePrefix' => 'backend.contact_messages',
                            'data' => $row
                        ])->render();
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('ContactMessageController error: ' . $e->getMessage());
                return response()->json([
                    'error' => 'Server Error: ' . $e->getMessage()
                ], 500);
            }
        }
        return view('backend.contact_messages.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('backend.contact_messages.show', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $message = ContactMessage::findOrFail($id);
        $message->update([
            'reply' => $request->reply,
            'status' => 'replied',
        ]);

        // In a real app, you'd send an email here
        // Mail::to($message->email)->send(new ContactReplyMail($message));

        return redirect()->route('backend.contact_messages.index')->with('success', 'Reply saved successfully and marked as replied.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ContactMessage::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully'
        ]);
    }
}
