<div class="mb-5">
    <p class="h6"> <strong> {{ $message->user->name }}</strong>
        <small class="text-muted"> {{ $message->created_at }}</small>
    </p>
    <p class="h6"> {{ $message->text }}</p>
    @if($message->user == auth()->user())
        <form action="{{ route('message.destroy', $message) }}" method="POST">
            @csrf
            @method("DELETE")
            <button type="success" class="btn btn-danger"> Удалить </button>
        </form>
    @endif

</div>