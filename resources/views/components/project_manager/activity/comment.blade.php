<div class="comment-chat-message {{ $message_side }}" id="comment-{{$comment->id}}">
    <div class="message-text">
        <img src="{{ getImageUrl($comment->user->avatar, 1) }}" class="comment-user-image {{ $message_side }}" alt="User image">
        <p class="truncate-text" truncate="90">
            {{$comment->contenido}}
        </p>
        @if ($comment->foto)
            <img src="{{ getImageUrl($comment->foto, 2) }}" class="comment-image" alt="Comment image">
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
    .comment-chat-message.right .comment-header {
        align-items: flex-end;
    }
    .comment-chat-message.right .comment-user-info {
        align-items: flex-end;
    }
    .comment-user-image {
        width: 23px;
        height: 23px;
        border-radius: 50%;
        float: left;
        margin: 2px 4.5px 0px 0px;
    }
    .comment-chat-message.right .comment-user-image {
        float: right;
        margin: 2px 0px 0px 4.5px;
    }
    .comment-user-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex-grow: 1;
        max-width: calc(88%);
        line-height: 1.1;
    }
    .comment-user-name {
        font-size: 9px;
        font-weight: bold;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .comment-user-time {
        color: gray;
        font-size: 8px;
    }
    .comment-chat-message .message-text {
        margin: 4px 3px 3px 3px;
        font-size: 9px;
        text-align: justify
    }
    .comment-image {
        width: 100%;
        height: auto;
        margin: 0;
        border-radius: 5px;
        margin-top: 5px;
    }
</style>