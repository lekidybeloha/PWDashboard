let dashboard = {};

dashboard.openTask = function (el) {
    $('#overlay').show();
    $('#listChecklist').html('');
    $('#etiqCreate').hide();
    $('#etiqSection').html('');
    var id_cart = el.attr('data-id');
    $('#id_dash_card_checklist').val(id_cart);
    $('#storeDueDate').attr('data-id', id_cart);
    $('#deleteDueDate').attr('data-id', id_cart);
    $('#cart_id_file').val(id_cart);
    $('#cart_id_dash_file').val(ID_DASHBOARD);
    $.get( cartDetails, { id: id_cart} )
        .done(function( data ) {
            if(data.due_date != ''){
                var dueDate = new Date(data.due_date);
                var today = new Date();
                if(dueDate < today){
                    var text = ' (Date d\'échéance atteinte)';
                    $('#dueDateText').html(data.due_date + text);
                }else{
                    var text = ' (Bientôt à échéance)';
                    $('#dueDateText').html(data.due_date + text);
                }
                $('#dueDateSection').show();
            }else{
                $('#dueDateSection').hide();
            }

            $('#storeDueDate').attr('data-id', data.id);
            $('#fakeDesc').html('Ajouter une description plus détaillée');
            if(data.description == ''){
                $('#overlay-description').hide();
                $('#fakeDesc').show();
            }else{
                $('#overlay-description').hide();
                $('#fakeDesc').show();
                $('#fakeDesc').html(data.description);
            }
            $('#descCart').val(data.description);
            $('#id_task').val(id_cart);
            refreshChecklist(id_cart);
            refreshComments(id_cart);
        });
    $('#task-title').html(el.attr('data-name'));
    var etiqSec   = '';
    $('.etiqSection').each(function () {
        var div     = $(this);

        $.get( checkEtiquettes, { id_etiquette: $(this).attr('data-id'), id_dashboard_task : id_cart} )
            .done(function( data ) {
                if(data.success == true){
                    div.append('<i class="fas fa-check"></i>');
                    etiqSec = etiqSec + '<span style="background-color: '+ div.css('background-color') +'" class="etiqSection">'+ data.name.name +'</span>';
                    $('#etiqSection').html(etiqSec);
                }
            });
    });

    var files = '';
    $('#fileSection').html('');
    $.get( getFiles, { id_cart: id_cart} )
        .done(function( data2 ) {
            if(data2.length > 0){
                $.each(data2, function (index, val) {
                    $('#fileSection').append('<img src="'+ val.path +'">');
                });
            }
        });

    $('#overlayListTitle').html(el.attr('data-list'));
    $('.window').show();
    $('.window-overlay').show();
    $('#overlay').hide();
};

dashboard.closeOverlay = function() {
    $('.window').hide();
    $('.window-overlay').hide();
};

dashboard.addCard = function (el) {
    /*
    $('#id_card').val(el.attr('data-card'));
    $('#createCard').modal();
    */
    $.each($('.carte-title'), function () {
        var one = $(this);
       if(one.attr('data-list') == el.attr('data-card')){
           one.show();
           one.focus();
       }
    });

    $.each($('.save-list'), function () {
        var one = $(this);
        if(one.attr('data-list') == el.attr('data-card')){
            one.show();
        }
    });
    el.hide();
    $('#card-popover').hide();
    $('#popover-addCard').show();
};

dashboard.arbortCreateList = function (el) {
    /*
    if(el.val() !== ''){
        $.each($('.save-list'), function () {
            var one = $(this);
            if(one.attr('data-list') == el.attr('data-list')){
                dashboard.saveList(one);
            }
        });
    }else{
        el.hide();
        $.each($('.save-list'), function () {
            var one = $(this);
            if(one.attr('data-list') == el.attr('data-list')){
                one.hide();
            }
        });
        $.each($('.addCard'), function () {
            var one = $(this);
            if(one.attr('data-card') == el.attr('data-list')){
                one.show();
            }
        });
    }*/

};

dashboard.saveList = function (el) {
    $('#overlay').show();
    $.each($('.carte-title'), function () {
        var one = $(this);
        if(one.attr('data-list') == el.attr('data-list')){
            if(one.val() == ''){

            }else{
                $.post( addCard, { id_card: one.attr('data-list'), name : one.val(), id_dashboard: el.attr('data-dashboard')} )
                    .done(function(data) {
                        $( "#dashboard-principal" ).load( updateMainDashboard);
                    });
            }
        }
    });
    $('#overlay').hide();
};

dashboard.editDesc = function () {
    $('#fakeDesc').hide();
    $('#overlay-description').show();
};

dashboard.saveDescription = function () {
    $('#overlay').show();
    $.get( saveCartDetails, { id: $('#id_task').val(), description : $('#descCart').val()} )
        .done(function() {
            $('#saveDesc').css('display', 'none');
            $('#fakeDesc').html($('#descCart').val());
            $('#overlay-description').hide();
            $('#fakeDesc').show();
            $('#overlay').hide();
        });
};

dashboard.updateFavoris = function () {
    var id_dashboard    = $('#iconFavorites').attr('data-id');
    var favorite        = $('#iconFavorites').attr('data-fav');

    $('#overlay').show();
    $.get( updateFavorites, { id_dashboard: id_dashboard, fav : favorite} )
        .done(function(data) {

            if(data.success == true){
                if(favorite == 1){
                    $('#iconFavorites').removeClass('far fa-star');
                    $('#iconFavorites').addClass('fas fa-star');
                    $('#iconFavorites').attr('data-fav', 0);
                }else{
                    $('#iconFavorites').removeClass('fas fa-star');
                    $('#iconFavorites').addClass('far fa-star');
                    $('#iconFavorites').attr('data-fav', 1);
                }
            }
            $('#overlay').hide();
        });
};

dashboard.openCreateEtiquette = function (el)   {
    $('.etiqLists').hide();
    $('.etiq-create').show();
    el.hide();
    $('.icon-back').show();
};

dashboard.closeCreateEtiquette = function(el)   {
    $('.etiqLists').show();
    $('.etiq-create').hide();
    el.hide();
    $('.createListBtn').show();
};

$(document).on('click', '.etiqColor', function () {
   $.each($('.etiqColor'), function () {
       $(this).find('i').remove();
   })

   $(this).append('<i class="fas fa-check"></i>');
   $('#etiqColor').val($(this).css('background-color'));
});

dashboard.createEtiquette = function () {
    var etiquetteName    = $('#etiqName').val();
    var color            = $('#etiqColor').val();
    if(etiquetteName == ''){
        alert('Veuillez choisir un nom d\'etiquette');
        return
    }
    $('#overlay').show();
    $.get( addEtiquettes, { id_dashboard: $('#id_dash').val(), name : etiquetteName, color: color} )
        .done(function(data) {
            if(data.success == true){
                ;
                $('#etiqSection').html('');
                var etiqSec   = '';
                $('.etiqSection').each(function () {
                    var div     = $(this);

                    $.get( checkEtiquettes, { id_etiquette: $(this).attr('data-id'), id_dashboard_task : $('#id_dash_card_checklist').val()} )
                        .done(function( data ) {
                            if(data.success == true){
                                div.append('<i class="fas fa-check"></i>');
                                etiqSec = etiqSec + '<span style="background-color: '+ div.css('background-color') +'" class="etiqSection">'+ data.name.name +'</span>';
                                $('#etiqSection').html(etiqSec);
                            }
                        });
                });
            }

            $('#overlay').hide();
        });
};

dashboard.addChecklistName = function ()    {
    $('#overlay').show();
    $.get( createChecklist, { id: $('#id_dash_card_checklist').val(), name : $('#id-checklist').val()} )
        .done(function(data) {
            $('#checklist-pop').hide();
            $('#overlay').hide();
        });
};

dashboard.saveChecklist = function (id_name) {
    $('#overlay').show();
    $.get( saveCartChecklist, { id_card: $('#id_task').val(), name : $('#textCheck_'+id_name).val(), id_user: ID_USER, id_checklist_name : id_name} )
        .done(function() {
            $('#checklistForm').fadeOut();
            refreshChecklist($('#id_task').val());
            $( "#dashboard-principal" ).load( updateMainDashboard);
            $('#overlay').hide();
        });
};

dashboard.saveComment = function () {
    $('#overlay').show();
    $.get( saveComments, { id_task: $('#id_task').val(), comment : $('#comment').val(), id_user: ID_USER} )
        .done(function() {
            $('#comment').val('');
            refreshComments($('#id_task').val());
            $( "#dashboard-principal" ).load( updateMainDashboard);
            $('#overlay').hide();
        });
};

dashboard.doneChecklist = function (el) {
    var checkbox = el;
    $('#overlay').show();
    if(checkbox.is(':checked')){
        $.get( updateChecklist, { id: checkbox.val(), value : 1} )
            .done(function() {
                $('#checklistForm').fadeOut();
                refreshChecklist(checkbox.attr('data-cart'));
                $( "#dashboard-principal" ).load( updateMainDashboard);
            });
    }else{
        $.get(  updateChecklist, { id: checkbox.val(), value : 0} )
            .done(function() {
                $('#checklistForm').fadeOut();
                refreshChecklist(checkbox.attr('data-cart'));
                $( "#dashboard-principal" ).load( updateMainDashboard);
            });
    }
    $('#overlay').hide();
};

dashboard.etiquetteDiv = function (el) {
    var id_etiquette = el.attr('data-id');
    var task         = $('#id_task').val();
    var element      = el;
    $('#dashboard-principal').html('');
    $('#overlay').show();
    $.get( insertOrDeleteEtiquette, { id_etiquette: id_etiquette, id_task : task} )
        .done(function(data) {
            $( "#dashboard-principal" ).load( updateMainDashboard, function() {
                if(data.erase == true){
                    element.find('i').remove();
                }else{
                    element.append('<i class="fas fa-check"></i>');
                }
                $('#overlay').hide();
            });
        });
};

dashboard.addCoop = function()  {
    $('#addCoop').modal();
}

dashboard.sendInvitation = function() {
    var email = $('#emailInvite').val();
    var text = $('#textInvite').val();
    var dashboard = $('#dashboardInvite').val();
    var token = $("input[name$='_token']").val();
    $('#overlay').show();
    $.post( sendingInvitation, { email: email, text : text, id_dashboard: dashboard, _token: token} )
        .done(function(data) {
            if(data.success == true){
                alert('Invitation envoyer avec succès');
                $('#addCoop').modal('toggle');
            }else{
                alert(data.error);
                $('#addCoop').modal('toggle');
            }
            $('#overlay').hide();
        });
};

dashboard.editListTitle = function(el) {
    el.hide();
    $( 'input[name="cardTitle"][value="'+el.html()+'"]' ).css('display', 'block');
    $( 'input[name="cardTitle"][value="'+el.html()+'"]' ).focus();
};

dashboard.donEditList = function(el) {
    $('#overlay').show();
    $.get( updateList, { id: el.attr('data-id'), title : el.val()} )
        .done(function(data) {
            el.hide();
            $(".card-title[data-id='"+el.attr('data-id')+"']").show();
            $( "#dashboard-principal" ).load( updateMainDashboard);
            $('#overlay').hide();
        });

};

dashboard.createList = function(el) {
    el.hide();
    $('#listeCreator').show();
};

dashboard.abortList = function()    {
    $('#listeCreator').hide();
    $('#creatorList').show();
};



dashboard.showCardPopover = function(el, id_cart) {
    var top     = el.offset().top;
    var left    = el.offset().left;

    $('#popover-addCard').attr('data-card', id_cart);

    $('#card-popover').css('display', 'block');
    $('#card-popover').css('top', top);
    $('#card-popover').css('left', left);
    $('#card-popover').focus();
    $('#countLists').attr('data-list', ID_DASHBOARD);
    $('#archiveListBtn').attr('data-id', id_cart);
};

dashboard.showChecklistPopover = function (el)  {
    var top     = el.offset().top;
    var left    = el.offset().left;

    $('#checklist-pop').css('display', 'block');
    $('#checklist-pop').css('top', top);
    $('#checklist-pop').css('left', left);
    $('#checklist-pop').focus();
};

dashboard.closePopover = function (el) {
    el.hide();
};

dashboard.addChecklistElements = function (el, id)  {
    $('.checklistForm').hide();
    $('#checklistForm_'+id).show();
};

dashboard.closeChecklistFormElements = function(id) {
    $('#checklistForm_'+id).hide();
};

$(document).on('click', '#sendInviteBtn', function (e) {
    e.preventDefault();
    dashboard.sendInvitation();
});

/*
Due Date
 */

dashboard.openDueDate = function(el)  {
    var top     = el.offset().top;
    var left    = el.offset().left;

    $('#dueDate-pop').css('display', 'block');
    $('#dueDate-pop').css('top', top);
    $('#dueDate-pop').css('left', left);
    $('#dueDate-pop').focus();
};

dashboard.getDate = function(el) {
    $('#dueDateInput').val(el.val());
};

dashboard.storeDueDate = function(el) {
    var id_cart = el.attr('data-id');
    if($('#dueDateInput').val().length == 0){
        alert('Veuillez selectionner une date et heure dans le calendrier');
        return;
    }
    $.get( updateDueDate, { id: id_cart, due_date : $('#dueDateInput').val()} )
        .done(function(data) {
            $.get( cartDetails, { id: id_cart} )
                .done(function( res ) {
                    if(res.due_date != ''){
                        var dueDate = new Date(res.due_date);
                        var today = new Date();
                        if(dueDate < today){
                            var text = ' (Date d\'échéance atteinte)';
                            $('#dueDateText').html(res.due_date + text);
                        }else{
                            var text = ' (Bientôt à échéance)';
                            $('#dueDateText').html(res.due_date + text);
                        }
                        $('#dueDateSection').show();
                    }else{
                        $('#dueDateSection').hide();
                    }

                });
        });
};

dashboard.deleteDueDate = function(el) {
    var id_cart = el.attr('data-id');

    $.get( updateDueDate, { id: id_cart, due_date : null} )
        .done(function(data) {
            $.get( cartDetails, { id: id_cart} )
                .done(function( res ) {
                    if(res.due_date != ''){
                        var dueDate = new Date(res.due_date);
                        var today = new Date();
                        if(dueDate < today){
                            var text = ' (Date d\'échéance atteinte)';
                            $('#dueDateText').html(res.due_date + text);
                        }else{
                            var text = ' (Bientôt à échéance)';
                            $('#dueDateText').html(res.due_date + text);
                        }
                        $('#dueDateSection').show();
                    }else{
                        $('#dueDateSection').hide();
                    }

                });
        });
};

/*
Etiquettes
 */

dashboard.showEtiquettePopover = function (el)  {
    var top     = el.offset().top;
    var left    = el.offset().left;

    $('#etiquette-pop').css('display', 'block');
    $('#etiquette-pop').css('top', top);
    $('#etiquette-pop').css('left', left);
    $('#etiquette-pop').focus();
};

$(document).ready(function () {
    $('#saveDesc').css('display', 'none');

    $('#descCart').bind('input propertychange', function () {
        $('#saveDesc').css('display', 'block');
    });

    /*
    Etiquettes section
     */
    $('#etiqButton').click(function () {
        $('#etiqList').show();
    });

    $('#etiqForm').click(function () {
        $('#etiqCreate').show();
    });

    $('#annulateEtiquette').click(function () {
        $('#etiqCreate').hide();
    });
});

dashboard.init = function () {

};

/*
LISTS MOVE
 */

dashboard.openListMoveDiv = function () {
    $('#overlay').show();
    $('#countLists').html('');
    $.get( getLists, { id_dashboard: ID_DASHBOARD} )
        .done(function(data) {
            $('#overlay').hide();
            $('#main-pop').hide();
            $('#moveListBtn').attr('data-card', data[0].id);
            var x = 1;
            $.each(data, function (index, val) {
                $('#countLists').append('<option value="'+ val.position +'">' + x + '</option>');
                x++;
            });
            $('#second-pop').show();
        });

};

dashboard.moveClick = function () {
    var id_cart = $('#moveListBtn').attr('data-card');
    $('#overlay').show();
    $.get( moveList, { id_cart: id_cart, position : $('#countLists').val()} )
        .done(function(data) {
            $( "#dashboard-principal" ).load( updateMainDashboard);
            $('#overlay').hide();
            $('#main-pop').show();
            $('#second-pop').hide();
            $('#card-popover').hide();
        });
};

dashboard.openCutList = function () {
    $('#overlay').show();
    $('#cardLists').html('');
    $.get( getLists, { id_dashboard: ID_DASHBOARD} )
        .done(function(data) {

            $('#main-pop').hide();
            $('#moveListBtn').attr('data-card', data[0].id);
            var x = 1;
            $.each(data, function (index, val) {
                $('#cardLists').append('<li ><a href="#" value="'+ val.id +'" onclick="dashboard.doMoveList($(this))">' + val.title + '</a></li>');
                x++;
            });
            $('#overlay').hide();
            $('#moveCard-pop').show();
        });
};

dashboard.doMoveList = function (el) {
    console.log(el.attr('value'));
};

dashboard.openArchiveDiv = function () {

};

dashboard.archiveList = function (el) {
    $('#overlay').show();
    $.get( archiveList, { id: el.attr('data-id')} )
        .done(function(data) {
            $( "#dashboard-principal" ).load( updateMainDashboard);
            $('#overlay').hide();
            $('#main-pop').show();
            $('#second-pop').hide();
            $('#card-popover').hide();
        });
};

dashboard.openUploadPopover = function (el) {
    var top     = el.offset().top;
    var left    = el.offset().left;
    $('#upload-popover').css('display', 'block');
    $('#upload-popover').css('top', top);
    $('#upload-popover').css('left', left);
    $('#upload-popover').focus();
};



