<div class="etiquettePop pop-over is-shown" style="display: none" id="etiquette-pop">
    <div class="no-back">
        <div class="pop-over-header js-pop-over-header">
            <a href="#" class="pop-over-header-back-btn icon-sm icon-back is-shown" onclick="dashboard.closeCreateEtiquette($(this))"><</a>
            <span class="pop-over-header-title">Etiquettes</span>
            <a href="#" class="pop-over-header-close-btn icon-sm icon-close" onclick="dashboard.closePopover($('#etiquette-pop'))">X</a>
        </div>
        <div>
            <div class="pop-over-content js-pop-over-content u-fancy-scrollbar js-tab-parent" style="max-height: 300px;">
                @if(!count($etiquettes))
                <div id="default">
                    <div>
                        <span class="etiqSection" style="width: 80%;background-color:#519839;"></span><i class="fas fa-pen etiqSection"></i>
                    </div>
                    <div>
                        <span class="etiqSection" style="width: 80%;background-color:#d9b51c;"></span><i class="fas fa-pen etiqSection"></i>
                    </div>
                    <div>
                        <span class="etiqSection" style="width: 80%;background-color:#cd8313;"></span><i class="fas fa-pen etiqSection"></i>
                    </div>
                    <div>
                        <span class="etiqSection" style="width: 80%;background-color:#b04632;"></span><i class="fas fa-pen etiqSection"></i>
                    </div>
                    <div>
                        <span class="etiqSection" style="width: 80%;background-color:#89609e;"></span><i class="fas fa-pen etiqSection"></i>
                    </div>
                    <div>
                        <span class="etiqSection" style="width: 80%;background-color:#055a8c;"></span><i class="fas fa-pen etiqSection"></i>
                    </div>
                </div>
                @else
                    @include('components.etiquettes')
                @endif
                    <button class="btn createListBtn form-control" style="margin-top: 10px" onclick="dashboard.openCreateEtiquette($(this))">Créer une nouvelle étiquette</button>
            </div>
        </div>
    </div>
</div>