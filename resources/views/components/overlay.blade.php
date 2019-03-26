<div class="window-overlay">
    <div class="window">
        <div id="cartDetails">
            <div class="overlay-container">

                <!-- Modal content-->
                <div>
                    <div class="overlay-header">
                        <h4 class="modal-title" id="task-title"></h4>
                        Dans la liste <a href="#" id="overlayListTitle"></a><br>
                        <button type="button" class="btn btn-default close-overlay" onclick="dashboard.closeOverlay()">X</button>
                    </div>
                    <div style="display: inline-flex;width: 100%">
                        <div style="width: 80%;margin-right: 25px;">
                            <div id="etiqSection">

                            </div>
                            <br>
                            <div id="dueDateSection">
                                <h3>DATE LIMITE</h3>
                                <span id="dueDateText"></span>
                            </div>

                            <label class="overlay-description">Description</label>
                            <div id="overlay-description">
                                <textarea id="descCart" class="form-control">Ajouter une description ici</textarea>
                                <input type="hidden" value="" id="id_task">
                                <button class="btn btn-success" id="saveDesc" onclick="dashboard.saveDescription()">Enregistrer</button>
                            </div>
                            <p id="fakeDesc" class="card-detail-fake-text-area" onclick="dashboard.editDesc()"></p>


                            @include('components.files')


                            <div id="checklist-overlay">

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
                            <button type="button" class="add-cart-list" id="etiqButton" onclick="dashboard.showEtiquettePopover($(this))"><span style="margin-left: 5px">Etiquettes</span></button>
                            <button type="button" class="add-cart-list" id="checklistButton" onclick="dashboard.showChecklistPopover($(this))"><i class="fas fa-check-square"></i><span style="margin-left: 5px">Checklist</span></button>
                            <button type="button" class="add-cart-list" onclick="dashboard.openDueDate($(this))"><i class="far fa-clock"></i><span style="margin-left: 5px">Date limite</span></button>
                            <button type="button" class="add-cart-list" onclick="dashboard.openUploadPopover($(this))" ><i class="fas fa-paperclip"></i><span style="margin-left: 5px">Pièce jointe</span></button>
                            <!--
                            <div id="etiqList">

                            </div>
                            <a href="#" id="etiqForm">Créer une étiquette</a>-->

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>