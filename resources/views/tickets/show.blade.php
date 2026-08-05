@extends('layouts.app')

@section('title', 'Αίτημα ' . $ticket->tracking_code)

@section('content')

    <h2 style="margin-top: 0;">{{ $ticket->title }}</h2>

    <fieldset style="margin-bottom: 16px;">
        <legend>Στοιχεία</legend>
        <p><strong>Κωδικός:</strong> {{ $ticket->tracking_code }}</p>
        <p><strong>Κατηγορία:</strong> {{ $ticket->category->name }}</p>
        <p><strong>Κατάσταση:</strong> {{ $ticket->status }}</p>
        <p><strong>Email:</strong> {{ $ticket->email }}</p>
    </fieldset>

    <fieldset style="margin-bottom: 16px;">
        <legend>Περιγραφή</legend>
        <p>{{ $ticket->description }}</p>
    </fieldset>

    <fieldset style="margin-bottom: 16px;">
        <legend>Αρχεία</legend>
        @forelse ($ticket->attachments as $attachment)
            <div style="margin-bottom: 10px;">
                @if (str_starts_with($attachment->mime_type, 'image/'))
                    <div style="padding: 4px; background: #fff; border: 1px solid #999; display: inline-block;">
                        <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $attachment->path) }}"
                                 alt="{{ $attachment->original_name }}"
                                 style="max-width: 200px; max-height: 200px; display: block;">
                        </a>
                    </div>
                    <br>
                    <small>{{ $attachment->original_name }}</small>
                @else
                    <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank">
                        📄 {{ $attachment->original_name }}
                    </a>
                @endif
            </div>
        @empty
            <p>Δεν υπάρχουν αρχεία.</p>
        @endforelse
    </fieldset>

    <fieldset style="margin-bottom: 16px;">
        <legend>Σχόλια</legend>
        @forelse ($ticket->comments as $comments)
            <div style="margin-bottom: 8px; padding: 6px; background: #fff; border: 1px solid #ccc;">
                <p style="margin: 0;">{{ $comments->body }}</p>
                <small style="color: #666;">{{ $comments->user->name ?? 'Πελάτης' }} — {{ $comments->created_at }}</small>
            </div>
        @empty
            <p>Δεν υπάρχουν σχόλια ακόμα.</p>
        @endforelse
    </fieldset>

    <fieldset>
        <legend>Προσθήκη σχολίου</legend>
        <form action="/ticket/{{ $ticket->uuid }}/comment" method="POST">
            @csrf
            <div class="field-row-stacked" style="margin-bottom: 8px;">
                <textarea name="body" rows="3" required></textarea>
            </div>
            <div style="text-align: right;">
                <button type="submit">Αποστολή</button>
            </div>
        </form>
    </fieldset>

@endsection