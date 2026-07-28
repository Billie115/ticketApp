<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket {{ $ticket->tracking_code }}</title>
</head>
<body>
    <h1>Αίτημα: {{ $ticket->title }}</h1>

    <p><strong>Κωδικός:</strong> {{ $ticket->tracking_code }}</p>
    <p><strong>Κατηγορία:</strong> {{ $ticket->category->name }}</p>
    <p><strong>Κατάσταση:</strong> {{ $ticket->status }}</p>
    <p><strong>Email:</strong> {{ $ticket->email }}</p>

    <h2>Περιγραφή</h2>
    <p>{{ $ticket->description }}</p>

    <h2>Σχόλια</h2>
    @forelse ($ticket->comments as $comments)
        <div>
            <p>{{ $comments->body }}</p>
            <small>{{ $comments->created_at }}</small>
        </div>
        @empty
        <p>Δεν υπάρχουν σχόλια ακόμα.</p>
    @endforelse

    <h3>Προσθήκη σχολίου</h3>
    <form action="/ticket/{{ $ticket->uuid}}/comment" method="POST">
        @csrf
        <textarea name="body" required></textarea>
        <button type="submit">Αποστολή</button>
    </form>
</body>
</html>