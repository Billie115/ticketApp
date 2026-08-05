@extends('layouts.app')

@section('title', 'Υποβολή Αιτήματος')

@section('content')

    @if ($errors->any())
        <div class="window" style="margin-bottom: 16px; background: #ffe;">
            <div class="title-bar" style="background: linear-gradient(180deg, #c00, #900);">
                <div class="title-bar-text">Σφάλμα</div>
            </div>
            <div class="window-body">
                <ul style="margin: 0; padding-left: 20px; color: #c00;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="/submit" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="field-row-stacked" style="margin-bottom: 12px;">
            <label for="title">Τίτλος</label>
            <input type="text" name="title" id="title">
        </div>

        <div class="field-row-stacked" style="margin-bottom: 12px;">
            <label for="category_id">Κατηγορία</label>
            <select name="category_id" id="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="field-row-stacked" style="margin-bottom: 12px;">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>

        <div class="field-row-stacked" style="margin-bottom: 12px;">
            <label for="description">Περιγραφή</label>
            <textarea name="description" id="description" rows="4"></textarea>
        </div>

        <div class="field-row-stacked" style="margin-bottom: 16px;">
            <label for="attachments">Αρχεία (pdf, εικόνες)</label>
            <input type="file" name="attachments[]" id="attachments" multiple>
        </div>

        <div style="text-align: right;">
            <button type="submit">Υποβολή</button>
        </div>
    </form>

@endsection