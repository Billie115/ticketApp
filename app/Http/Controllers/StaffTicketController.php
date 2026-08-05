<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class StaffTicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::query()
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->tracking_code, function ($query, $code) {
                $query->where('tracking_code', 'like', '%' . $code . '%');
            })
            ->latest()
            ->get();

        return view('staff.tickets.index', [
            'tickets' => $tickets,
        ]);
    }
    public function show(Ticket $ticket)
    {
        $ticket->load('category', 'comments', 'attachments', 'assignee');
        $employees = \App\Models\User::all();

        return view('staff.tickets.show', [
            'ticket' => $ticket,
            'employees' => $employees,
        ]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:in_progress,completed,cancelled',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);

        return redirect('/staff/tickets/' . $ticket->id);
    }

    public function addComment(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $ticket->comments()->create([
            'body' => $validated['body'],
            'user_id' => 1,
        ]);

        return redirect('/staff/tickets/' . $ticket->id);
    }

    public function addAttachment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'attachments' => 'required|array',
            'attachments.*' => 'file|extensions:pdf,png,jpg,jpeg|max:10240',
        ]);

        foreach ($request->file('attachments', []) as $file) {
            $path = $file->store('attachments', 'public');

            $ticket->attachments()->create([
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
            ]);
        }

        return redirect('/staff/tickets/' . $ticket->id);
    }
}