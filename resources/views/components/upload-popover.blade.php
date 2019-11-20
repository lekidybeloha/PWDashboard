<div class="pop-over is-shown" id="upload-popover" tabindex='1'>
    <div class="no-back">
        <div class="pop-over-header js-pop-over-header">
            <span class="pop-over-header-title">Ajouter une pièce jointe depuis</span>
            <a href="#" class="pop-over-header-close-btn icon-sm icon-close" onclick="dashboard.closePopover($('#upload-popover'))">X</a>
        </div>
        <div>
            <div class="pop-over-content js-pop-over-content u-fancy-scrollbar js-tab-parent" style="max-height: 844px;">
                <div id="main-pop">
                    <form method="POST" action="{{ route('uploadFile') }}" enctype="multipart/form-data">
                        <input type="file" name="file">
                        <input type="hidden" id="cart_id_file" name="id_task" value="">
                        <input type="hidden" id="cart_id_dash_file" name="id_dashboard" value="">
                        <input type="submit" value="Envoyer">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>