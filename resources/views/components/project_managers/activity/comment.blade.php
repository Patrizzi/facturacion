<div class="chat-message @if ($comment->user_id == auth()->id()) right @else left @endif" id="comment-{{$comment->id}}">
    <div class="comment-header">
        <img src="{{ isset($comment->user->avatar) ? asset('/profile/images/') . '/' . $comment->user->avatar : 'https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png' }}" class="chat-worker-image" alt="chat worker image">
        <div class="comment-user-info">
            <div class="worker-name">{{ Str::ucfirst($comment->user->nombre ?? $comment->user->name) }}</div>
        </div>
    </div>
    <div class="chat-message-text">
        <p class="truncate-text" truncate="90">
            {{$comment->contenido}}
        </p>
    </div>
    @if ($comment->foto) <img src="{{ $comment->foto }}" class="chat-attached-image" alt="chat-attached-image"> @endif
</div>