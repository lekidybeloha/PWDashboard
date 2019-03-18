@if(!empty($etiquettes))
    <div class="etiqLists">
    @foreach($etiquettes as $one)
        <span style="background-color: {{ $one->color }}; color: white;width: 80%;" class="etiqSection" data-id="{{ $one->id }}" onclick="dashboard.etiquetteDiv($(this))">{{ $one->name }}

        </span>
    @endforeach
    </div>
    <div class="etiq-create" style="display: none;">
        <label>Nom</label>
        <input type="text" id="etiqName" value="">
        <span style="background-color: #61bd4f" class="etiqSection etiqColor"></span>
        <span style="background-color: #f2d600" class="etiqSection etiqColor"></span>
        <span style="background-color: #ff9f1a" class="etiqSection etiqColor"></span>
        <span style="background-color: #eb5a46" class="etiqSection etiqColor"></span>
        <span style="background-color: #c377e0" class="etiqSection etiqColor"></span>
        <span style="background-color: #0079bf" class="etiqSection etiqColor"></span>
        <span style="background-color: #00c2e0" class="etiqSection etiqColor"><i class="fas fa-check"></i></span>
        <span style="background-color: #51e898" class="etiqSection etiqColor"></span>
        <span style="background-color: #ff78cb" class="etiqSection etiqColor"></span>
        <span style="background-color: #355263" class="etiqSection etiqColor"></span>
        <div style="display: block">
            <input type="hidden" id="id_dash" class="form-control" placeholder="code couleur" value="{{ $dashboard->id }}">
            <input type="hidden" id="etiqColor" value="#00c2e0">
            <button class="btn btn-success" onclick="dashboard.createEtiquette()">Créer</button>
        </div>

    </div>
@endif