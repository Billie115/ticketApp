<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Υποβολή Ticket</title>
</head>
<body>
    <h1>Υποβολή νέου αιτήματος</h1>

    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/submit" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="title">Τίτλος</label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="category_id">Κατηγορία</label>
            <select name="category_id" id="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="descreption">Περιγραφή</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div>
            <label for="attachments">Αρχεία (pdf, εικόνες)</label>
            <input type="file" name="attachments[]" id="attachments" multiple>
        </div>
        <button type="submit">Υποβολή</button>
    </form>
</body>
</html>