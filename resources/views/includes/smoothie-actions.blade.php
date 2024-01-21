<!-- resources/views/includes/smoothie-actions.blade.php -->

<div class="card-footer text-end">
    @auth
        @if(Auth::user()->id == $smoothie->user_id || Auth::user()->hasRole('admin'))
            <a href="{{ $editRoute }}" class="btn btn-primary">Edit</a>
            <form action="{{ $deleteRoute }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endif

        @isset($toggleStatusRoute)
            <form action="{{ $toggleStatusRoute }}" method="POST" style="display: inline-block;">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    {{ $smoothie->active ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
        @endisset
    @endauth
</div>
