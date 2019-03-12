@if(!empty($etiquettes))
    @foreach($etiquettes as $one)
        <span style="background-color: {{ $one->color }}; color: white;width: 80%;" class="etiqSection" data-id="{{ $one->id }}" onclick="dashboard.etiquetteDiv($(this))">{{ $one->name }}

        </span>
    @endforeach
@endif