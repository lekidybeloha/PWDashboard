@if(!empty($etiquettes))
    @foreach($etiquettes as $one)
        <div style="background-color: {{ $one->color }}; color: white" class="etiqDiv" data-id="{{ $one->id }}">{{ $one->name }}

        </div>
    @endforeach
@endif