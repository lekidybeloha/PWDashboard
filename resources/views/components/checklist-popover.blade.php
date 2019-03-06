<div class="checklistPop pop-over is-shown" style="display: none" id="checklist-pop">
    <div class="no-back">
        <div class="pop-over-header js-pop-over-header">
            <span class="pop-over-header-title">Ajouter une checklist</span>
            <a href="#" class="pop-over-header-close-btn icon-sm icon-close"></a>
        </div>
        <div>
            <div class="pop-over-content js-pop-over-content u-fancy-scrollbar js-tab-parent" style="max-height: 300px;">
                <div>
                    <div>
                        <label for="id-checklist">Titre</label>
                        <input type="hidden" value="" id="id_dash_card_checklist">
                        <input id="id-checklist" class="js-checklist-title js-autofocus" type="text" value="Checklist" data-default="Checklist" dir="auto" >
                        <input class="primary wide confirm js-add-checklist" type="submit" value="Ajouter" onclick="dashboard.addChecklistName()">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>