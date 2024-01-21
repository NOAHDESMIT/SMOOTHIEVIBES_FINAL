@foreach ($smoothies as $smoothie)
    <!-- Display smoothie details -->
    <p>{{ $smoothie->name }}</p>
    <!-- Add buttons for toggle status, edit, and delete -->
    <form action="{{ route('profile.smoothies.toggle-status', $smoothie) }}" method="post">
        @csrf
        <button type="submit">Toggle Status</button>
    </form>
    <a href="{{ route('profile.smoothies.edit', $smoothie) }}">Edit</a>
    <form action="{{ route('profile.smoothies.delete', $smoothie) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit">Delete</button>
    </form>
@endforeach
