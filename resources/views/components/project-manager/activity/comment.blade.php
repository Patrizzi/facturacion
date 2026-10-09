{{-- @push('css') 
    @once
        <link rel="stylesheet" href="{{ asset('css/project_managers/cards/comment.css') }}">
    @endonce
@endpush --}}
<div class="comment-chat-message {{ $message_side }}" id="comment-{{$comment->id}}">
    <div class="message-text">
        <img src="{{ $user_foto }}" class="comment-user-image {{ $message_side }}" alt="User image">
        <p>
            {!! nl2br(e($comment->contenido)) !!}
        </p>
        @if ($comment->foto)
            <img src="{{ getImageUrl($comment->foto, 2) }}" class="comment-image" alt="Comment image">
        @endif
    </div>
</div>