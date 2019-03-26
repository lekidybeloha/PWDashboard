<div class="dueDate pop-over is-shown" style="display: none" id="dueDate-pop">
    <div class="no-back">
        <div class="pop-over-header js-pop-over-header">
            <span class="pop-over-header-title">Changer la date limite</span>
            <a href="#" class="pop-over-header-close-btn icon-sm icon-close" onclick="dashboard.closePopover($('#dueDate-pop'))">X</a>
        </div>
        <div>
            <div class="pop-over-content js-pop-over-content u-fancy-scrollbar js-tab-parent">
                <!--
                <div class="datepicker-select u-clearfix" style="height: 75px;">
                    <div class="datepicker-select-date">
                        <label class="datepicker-select-label">Date
                            <input class="datepicker-select-input js-dpicker-date-input js-autofocus" type="text" placeholder="Entrer une date" tabindex="101" id="dueDateInput">
                        </label>
                    </div>
                    <div class="datepicker-select-time">
                        <label class="datepicker-select-label">Heure
                            <input class="datepicker-select-input js-dpicker-time-input" type="text" id="timeDateInput" placeholder="Saisir l'heure." tabindex="102">
                        </label>
                    </div>
                </div>-->
                <input class="datepicker-select-input js-dpicker-date-input js-autofocus" type="text" placeholder="Entrer une date" tabindex="101" id="dueDateInput" disabled>
                <div class="datepicker-here" data-language='fr' data-timepicker="true" onclick="dashboard.getDate($(this))"></div>
                <button class="btn btn-success form-control" style="margin-top: 10px" id="storeDueDate" data-id="" onclick="dashboard.storeDueDate($(this))">Enregistrer</button>
                <button class="btn btn-danger form-control" style="margin-top: 10px" id="deleteDueDate" data-id="" onclick="dashboard.deleteDueDate($(this))">Retirer</button>


            </div>
        </div>
    </div>
</div>