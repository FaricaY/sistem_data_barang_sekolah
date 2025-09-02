<h1>Edit Condition</h1>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('conditions.update', $condition->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Condition Name:</label><br>
    <input type="text" name="condition_name" value="{{ old('condition_name', $condition->condition_name) }}"><br><br>

    <label>Description:</label><br>
    <textarea name="description">{{ old('description', $condition->description) }}</textarea><br><br>

    <button type="submit">Update</button>
</form>
<a href="{{ route('conditions.index') }}">Kembali</a>
