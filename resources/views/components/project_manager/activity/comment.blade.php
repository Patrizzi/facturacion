<div class="comment-chat-message {{ $message_side }}" id="comment-{{$comment->id}}">
    <div class="comment-header">
        <img src="{{ getImageUrl($comment->user->avatar, 1) }}" class="comment-user-image" alt="User image">
        <div class="comment-user-info">
            <div class="comment-user-name">{{ $user_name }}</div>
            <div class="comment-user-time">{{ createdTime($comment) }}</div>
        </div>
    </div>
    <div class="message-text">
        <p class="truncate-text" truncate="90">
            {{$comment->contenido}}
        </p>
        @if ($comment->foto)
            <img src="{{ getImageUrl($comment->foto,2) }}" class="comment-image" alt="Comment image">
        @endif
    </div>
</div>
<style>
    .comment-chat-message {
        margin-bottom: 10px;
        padding: 5px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .comment-chat-message.right {
        background-color: #eafdf5;
    }
    .comment-chat-message.left {
        background-color: #e0e0e0;
    }
    .comment-header {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .comment-user-image {
        width: 21px;
        height: 21px;
        border-radius: 50%;
        margin: 1px 5px 0px 0px;
    }
    .comment-user-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        font-size: 10px;
        flex-grow: 1;
        max-width: calc(88%);
    }
    .comment-user-name {
        font-weight: bold;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .comment-user-time {
        color: gray;
        font-size: 8.5px;
    }
    .comment-chat-message .message-text {
        margin-top: 4px;
        margin-bottom: 3px;
        margin-left: 3px;
        font-size: 10.3px;
    }
    .comment-image {
        width: 100%;
        height: auto;
        margin: 0;
        border-radius: 5px;
        margin-top: 5px;
    }
</style>
    
</style>