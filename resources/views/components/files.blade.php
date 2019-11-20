<div>
    @if(isset($data) && count($data))
        @foreach($data as $one)
            <img src="{{$one->path}}">
        @endforeach
    @endif
</div>