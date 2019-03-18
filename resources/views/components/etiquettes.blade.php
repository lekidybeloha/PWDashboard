@if(!empty($etiquettes))
    <div class="etiqLists">
    @foreach($etiquettes as $one)
        <span style="background-color: {{ $one->color }}; color: white;width: 80%;" class="etiqSection" data-id="{{ $one->id }}" onclick="dashboard.etiquetteDiv($(this))">{{ $one->name }}

        </span>
    @endforeach
    </div>
    <div class="etiq-create" style="display: none;">
        <label>Nom</label>
        <input type="text">
        <span style="background-color: #61bd4f" class="etiqSection"></span>
        <span style="background-color: #f2d600" class="etiqSection"></span>
        <span style="background-color: #ff9f1a" class="etiqSection"></span>
        <span style="background-color: #eb5a46" class="etiqSection"></span>
        <span style="background-color: #c377e0" class="etiqSection"></span>
        <span style="background-color: #0079bf" class="etiqSection"></span>
        <span style="background-color: #00c2e0" class="etiqSection"></span>
        <span style="background-color: #51e898" class="etiqSection"></span>
        <span style="background-color: #ff78cb" class="etiqSection"></span>
        <span style="background-color: #355263" class="etiqSection"></span><br>
        <button class="btn btn-success">Créer</button>
    </div>
@endif