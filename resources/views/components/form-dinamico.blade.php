<div class="form-cell">
    <label for="{{$name}}">{{$label}}</label>
    @if ($type=='text' or $type=='datetime-local')
        <input type="{{$type}}" placeholder="{{$placeholder}}" name="{{$name}}" value="{{$value}}" required>
    @elseif($type=='number')
        <input type="{{$type}}" placeholder="{{$placeholder}}" name="{{$name}}" value="{{$value}}" step="1" min="1" required>
    @endif
</div>