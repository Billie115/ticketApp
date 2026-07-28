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

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'email' => 'required|email',
            'description' => 'nullable|string',
        ]);
        
        $ticket = Ticket::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'email' => $validated['email'],
            'description' => $validated['description'] ?? null,
        ]);

        return 'Το Ticket δημιουργήθηκε, Tracking code:' . $ticket->tracking_code;
    } 
}
