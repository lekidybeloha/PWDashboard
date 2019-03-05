<div class="window-overlay">
    <div class="window">
        <div id="cartDetails">
            <div class="overlay-container">

                <!-- Modal content-->
                <div>
                    <div class="overlay-header">
                        <h4 class="modal-title" id="task-title"></h4>
                        Dans la liste de <a href="#" id="overlayListTitle"></a><br>
                        <button type="button" class="btn btn-default close-overlay" onclick="dashboard.closeOverlay()">X</button>
                    </div>
                    <div style="display: inline-flex;width: 100%">
                        <div style="width: 80%">
                            <div id="etiqSection">

                            </div>
                            <label class="overlay-description">Description</label>
                            <textarea id="descCart" class="form-control">Ajouter une description ici</textarea>
                            <input type="hidden" value="" id="id_task">
                            <button class="btn btn-success" id="saveDesc" onclick="dashboard.saveDescription()">Enregistrer</button>

                            <label class="title">Checklist</label>
                            <div class="progress">
                                <div class="progress-bar" id="checkProgress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div id="listChecklist">
                            </div>

                            <button class="btn btn-info" id="addChecklist">Ajout checklist</button>
                            <div id="checklistForm" style="display: none;">
                                <input type="text" value="" id="checklistText" name="name" class="form-control">
                                <input type="hidden" value="{{ $id_user }}" name="id_user" id="id_user">
                                <button class="btn btn-success" id="saveChecklist" onclick="dashboard.saveChecklist()">Enregistrer</button>
                                <button class="btn btn-danger" id="cancelChecklist">Annuler</button>
                            </div>
                            <br>
                            <label class="title">Commentaires</label>
                            <div id="listComments">
                            </div>
                            <label >Ajouter un commentaire</label>
                            <div id="addComments">
                                <textarea id="comment" class="form-control"></textarea>
                                <button class="btn btn-success" id="saveComment" onclick="dashboard.saveComment()">Enregistrer</button>
                            </div>
                        </div>
                        <div style="width: 20%; text-align: center">
                            <label>AJOUTER A LA CARTE</label>
                            <button type="button" class="add-cart-list" id="etiqButton">Etiquettes</button>
                            <div id="etiqList">
                                @include('components.etiquettes')
                            </div>
                            <a href="#" id="etiqForm">Créer une étiquette</a>
                            <div id="etiqCreate" style="display: none;">
                                <input type="text" id="etiqName" class="form-control" placeholder="nom de l'etiquette">
                                <label>Couleur</label>
                                <input type="color" id="etiqColor" class="form-control" placeholder="code couleur">
                                <input type="hidden" id="id_dash" class="form-control" placeholder="code couleur" value="{{ $dashboard->id }}">
                                <button type="button" class="btn btn-success" id="createEtiquette" onclick="dashboard.createEtiquette()">Valider</button>
                                <button type="button" class="btn btn-danger" id="annulateEtiquette">Annuler</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>