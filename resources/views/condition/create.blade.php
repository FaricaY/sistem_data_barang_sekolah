<h1>Create Condition</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('conditions.store') }}" method="POST">
    @csrf
    <label>Condition Name:</label><br>
    <input type="text" name="condition_name" value="{{ old('condition_name') }}" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required="required">{{ old('description') }}</textarea><br><br>

    <button type="submit">Create Condition</button>
</form>
<a href="{{ route('conditions.index') }}">Back</a>
