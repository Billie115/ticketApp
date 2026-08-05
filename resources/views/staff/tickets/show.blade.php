@extends('layouts.xp')

@section('title', 'Διαχείριση ' . $ticket->tracking_code)

@section('content')
    @if ($errors->any())
            <div class="window" style="margin-bottom: 16px;">
                <div class="title-bar" style="background: linear-gradient(180deg, #c00, #900);">
                    <div class="title-bar-text">Σφάλμα</div>
                </div>
                <div class="window-body">
                    <ul style="margin:0; padding-left:20px; color:#c00;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div style="margin-bottom: 10px;">
            <a href="/staff/tickets">← Πίσω στη λίστα</a>
        </div>
    <fieldset style="margin-bottom: 16px;">
        <legend>Στοιχεία</legend>
        <p><strong>Τίτλος:</strong> {{ $ticket->title }}</p>
        <p><strong>Κατηγορία:</strong> {{ $ticket->category->name }}</p>
        <p><strong>Email:</strong> {{ $ticket->email }}</p>
        <p><strong>Περιγραφή:</strong> {{ $ticket->description }}</p>
        <p><strong>UUID:</strong> {{ $ticket->uuid }}</p>
    </fieldset>

    <fieldset style="margin-bottom: 16px;">
        <legend>Διαχείριση</legend>
        <form action="/staff/tickets/{{ $ticket->id }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="field-row-stacked" style="margin-bottom: 10px;">
                <label for="status">Κατάσταση</label>
                <select name="status" id="status">
                    <option value="in_progress" @selected($ticket->status == 'in_progress')>Σε εξέλιξη</option>
                    <option value="completed" @selected($ticket->status == 'completed')>Ολοκληρωμένο</option>
                    <option value="cancelled" @selected($ticket->status == 'cancelled')>Ακυρωμένο</option>
                </select>
            </div>

            <div class="field-row-stacked" style="margin-bottom: 10px;">
                <label for="assigned_to">Ανατέθηκε σε</label>
                <select name="assigned_to" id="assigned_to">
                    <option value="">-</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" @selected($ticket->assigned_to == $employee->id)>{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit">Ενημέρωση</button>
        </form>
    </fieldset>

    <fieldset style="margin-bottom: 16px;">
        <legend>Αρχεία</legend>
        @forelse ($ticket->attachments as $attachment)
            <div><a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">{{ $attachment->original_name }}</a></div>
        @empty
            <p>Δεν υπάρχουν αρχεία.</p>
        @endforelse

        <form action="/staff/tickets/{{ $ticket->id }}/attachment" method="POST" enctype="multipart/form-data" style="margin-top: 10px;">
            @csrf
            <input type="file" name="attachments[]" multiple>
            <button type="submit">Ανέβασμα</button>
        </form>
    </fieldset>

    <fieldset>
        <legend>Σχόλια</legend>
        @forelse ($ticket->comments as $comment)
            <div style="margin-bottom: 8px; padding: 6px; background: #fff; border: 1px solid #ccc;">
                <p style="margin: 0;">{{ $comment->body }}</p>
                <small>{{ $comment->user->name ?? 'Πελάτης' }} - {{ $comment->created_at }}</small>
            </div>
        @empty
            <p>Δεν υπάρχουν σχόλια.</p>
        @endforelse

        <form action="/staff/tickets/{{ $ticket->id }}/comment" method="POST" style="margin-top: 10px;">
            @csrf
            <div class="field-row-stacked" style="margin-bottom: 8px;">
                <textarea name="body" rows="3" required></textarea>
            </div>
            <button type="submit">Αποστολή</button>
        </form>
    </fieldset>

@endsection