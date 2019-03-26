<div class="pop-over is-shown" id="card-popover" tabindex='1'>
    <div class="no-back">
        <div class="pop-over-header js-pop-over-header">
            <span class="pop-over-header-title">Liste des actions</span>
            <a href="#" class="pop-over-header-close-btn icon-sm icon-close" onclick="dashboard.closePopover($('#card-popover'))">X</a>
        </div>
        <div>
            <div class="pop-over-content js-pop-over-content u-fancy-scrollbar js-tab-parent" style="max-height: 844px;">
                <div id="main-pop">
                    <div>
                        <ul class="pop-over-list">
                            <li><a class="js-add-card" href="#" id="popover-addCard" data-card="" onclick="dashboard.addCard($(this))">Ajouter une carte…</a></li>
                            <!--<li><a class="js-copy-list" href="#">Copier la liste…</a></li>-->
                            <li><a class="js-move-list" href="#" onclick="dashboard.openListMoveDiv()">Déplacer la liste…</a></li>
                            <li><a class="highlight-icon js-list-subscribe" href="#">Suivre </a></li>
                        </ul>
                        <hr>
                        <ul class="pop-over-list">
                            <!--<li><a class="js-move-cards" onclick="dashboard.openCutList()" href="#">Déplacer toutes les cartes de cette liste…</a></li>
                            <li><a class="js-archive-cards" href="#">Archiver toutes les cartes de cette liste…</a></li>-->
                        </ul>
                        <hr>
                        <ul class="pop-over-list">
                            <li><a class="js-close-list" href="#" id="archiveListBtn" data-id="" onclick="dashboard.archiveList($(this))">Archiver cette liste</a></li>
                        </ul>
                    </div>
                </div>
                <div id="second-pop" style="display: none;">
                    <select id="countLists" class="form-control">

                    </select>
                    <button class="btn btn-success" data-cart="" id="moveListBtn" onclick="dashboard.moveClick()">Déplacer</button>
                </div>
                <div id="moveCard-pop" style="display: none">
                    <ul id="cardLists">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>