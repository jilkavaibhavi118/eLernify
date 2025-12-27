<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ContactMessage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactMessage::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status == 'replied'
                        ? '<span class="badge bg-success">Replied</span>'
                        : '<span class="badge bg-warning text-dark">Pending</span>';
                })
                ->addColumn('action', function($row){
                    $showUrl   = route('backend.contact_messages.show', $row->id);
                    $deleteUrl = route('backend.contact_messages.destroy', $row->id);

                    $btn  = '<div class="d-flex gap-2">';

                    // Show/Reply Button
                    $btn .= '<a href="' . $showUrl . '" class="btn btn-info btn-sm d-flex align-items-center gap-1 text-white" title="View & Reply">';
                    $btn .= '<svg class="icon icon-sm"><use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-comment-square"></use></svg>';
                    $btn .= '<span>View & Reply</span></a>';

                    // Delete Button
                    $btn .= '<a href="javascript:void(0)" data-url="'.$deleteUrl.'" class="btn btn-danger btn-sm d-flex align-items-center gap-1 delete-btn" title="Delete">';
                    $btn .= '<svg class="icon icon-sm"><use xlink:href="' . asset('vendors/@coreui/icons/svg/free.svg') . '#cil-trash"></use></svg>';
                    $btn .= '<span>Delete</span></a>';

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
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
