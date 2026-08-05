@extends('layouts.xp')

@section('title', 'Tickets - Staff')

@section('content')

    <form method="GET" action="/staff/tickets" style="margin-bottom: 16px;">
        <div style="display: flex; gap: 10px; align-items: flex-end;">
            <div class="field-row-stacked">
                <label for="status">Κατάσταση</label>
                <select name="status" id="status">
                    <option value="">Όλες</option>
                    <option value="in_progress" @selected(request('status') == 'in_progress')>Σε εξέλιξη</option>
                    <option value="completed" @selected(request('status') == 'completed')>Ολοκληρωμένο</option>
                    <option value="cancelled" @selected(request('status') == 'cancelled')>Ακυρωμένο</option>
                </select>
            </div>
            <div class="field-row-stacked">
                <label for="tracking_code">Κωδικός</label>
                <input type="text" name="tracking_code" id="tracking_code" value="{{ request('tracking_code') }}">
            </div>
            <div>
                <button type="submit">Φίλτρο</button>
            </div>
        </div>
    </form>

    <table class="interactive" style="width: 100%;">
        <thead>
            <tr>
                <th>Κωδικός</th>
                <th>Τίτλος</th>
                <th>Κατηγορία</th>
                <th>Κατάσταση</th>
                <th>Ανατέθηκε σε</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->tracking_code }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->category->name }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->assignee->name ?? '-' }}</td>
                    <td><a href="/staff/tickets/{{ $ticket->id }}">Άνοιγμα</a></td>
                </tr>
            @empty
                <tr><td colspan="6">Δεν βρέθηκαν tickets.</td></tr>
            @endforelse
        </tbody>
    </table>

@endsection