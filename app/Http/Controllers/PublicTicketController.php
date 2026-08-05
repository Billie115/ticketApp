<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;

class PublicTicketController extends Controller
{
    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'email' => 'required|email',
            'description' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,png,jpg,jpeg|max:10240'
        ]);
        
    //dd($request->allFiles());

        $ticket = Ticket::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'email' => $validated['email'],
            'description' => $validated['description'] ?? null,
        ]);

        foreach ($request->file('attachments', []) as $file){
            $path = $file->store('attachments', 'public');

            $ticket->attachments()->create([
                'path'=> $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
            ]);
        }

        \Illuminate\Support\Facades\Mail::to($ticket->email)->send(new \App\Mail\TicketCreated($ticket));

        return redirect('/ticket/' . $ticket->uuid);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('category', 'comments.user');

        return view('tickets.show',[
            'ticket' => $ticket,
        ]);
    }

    public function addComment(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $ticket->comments()->create([
            'body' => $validated['body'],
            'user_id' => null,
        ]);

        return redirect('/ticket/' . $ticket->uuid);
    }
}
