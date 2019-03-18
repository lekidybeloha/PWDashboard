let dashboard = {};

dashboard.openTask = function (el) {
    $('#listChecklist').html('');
    $('#etiqCreate').hide();
    $('#etiqSection').html('');
    var id_cart = el.attr('data-id');
    $('#id_dash_card_checklist').val(id_cart);
    $.get( cartDetails, { id: id_cart} )
        .done(function( data ) {
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

    $('#overlayListTitle').html(el.attr('data-list'));
    $('.window').show();
    $('.window-overlay').show();
}

dashboard.closeOverlay = function() {
    $('.window').hide();
    $('.window-overlay').hide();
}

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
}

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

}

dashboard.saveList = function (el) {
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
}

dashboard.editDesc = function () {
    $('#fakeDesc').hide();
    $('#overlay-description').show();
}

dashboard.saveDescription = function () {
    $.get( saveCartDetails, { id: $('#id_task').val(), description : $('#descCart').val()} )
        .done(function() {
            $('#saveDesc').css('display', 'none');
            $('#fakeDesc').html($('#descCart').val());
            $('#overlay-description').hide();
            $('#fakeDesc').show();
        });
}

dashboard.updateFavoris = function () {
    var id_dashboard    = $('#iconFavorites').attr('data-id');
    var favorite        = $('#iconFavorites').attr('data-fav');


    $.get( updateFavorites, { id_dashboard: id_dashboard, fav : favorite} )
        .done(function(data) {
            console.log(data);
            console.log(favorite);
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
        });
}

dashboard.openCreateEtiquette = function (el)   {
    $('.etiqLists').hide();
    $('.etiq-create').show();
    el.hide();
}


dashboard.createEtiquette = function () {
    var etiquetteName    = $('#etiqName').val();
    var color            = $('#etiqColor').val();
    if(etiquetteName == ''){
        alert('Veuillez choisir un nom d\'etiquette');
        return
    }
    $.get( addEtiquettes, { id_dashboard: $('#id_dash').val(), name : etiquetteName, color: color} )
        .done(function(data) {
            if(data.success == true){
                $('#etiqCreate').hide();
                $( "#etiqList" ).load( updateEtiquetteList);
            }
        });
}

dashboard.addChecklistName = function ()    {
    $.get( createChecklist, { id: $('#id_dash_card_checklist').val(), name : $('#id-checklist').val()} )
        .done(function(data) {
            $('#checklist-pop').hide();
        });
}

dashboard.saveChecklist = function (id_name) {
    $.get( saveCartChecklist, { id_card: $('#id_task').val(), name : $('#textCheck_'+id_name).val(), id_user: ID_USER, id_checklist_name : id_name} )
        .done(function() {
            $('#checklistForm').fadeOut();
            refreshChecklist($('#id_task').val());
            $( "#dashboard-principal" ).load( updateMainDashboard);
        });
}

dashboard.saveComment = function () {
    $.get( saveComments, { id_task: $('#id_task').val(), comment : $('#comment').val(), id_user: $('#id_user').val()} )
        .done(function() {
            $('#comment').val('');
            refreshComments($('#id_task').val());
            $( "#dashboard-principal" ).load( updateMainDashboard);
        });
}

dashboard.doneChecklist = function (el) {
    var checkbox = el;
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
}

dashboard.etiquetteDiv = function (el) {
    var id_etiquette = el.attr('data-id');
    var task         = $('#id_task').val();
    var element      = el;
    $('#dashboard-principal').html('');
    $.get( insertOrDeleteEtiquette, { id_etiquette: id_etiquette, id_task : task} )
        .done(function(data) {
            $( "#dashboard-principal" ).load( updateMainDashboard, function() {
                if(data.erase == true){
                    element.find('i').remove();
                }else{
                    element.append('<i class="fas fa-check"></i>');
                }
            });
        });
}

dashboard.addCoop = function()  {
    $('#addCoop').modal();
}

dashboard.sendInvitation = function() {
    var email = $('#emailInvite').val();
    var text = $('#textInvite').val();
    var dashboard = $('#dashboardInvite').val();
    var token = $("input[name$='_token']").val();
    $.post( sendingInvitation, { email: email, text : text, id_dashboard: dashboard, _token: token} )
        .done(function(data) {
            if(data.success == true){
                alert('Invitation envoyer avec succès');
                $('#addCoop').modal('toggle');
            }else{
                alert(data.error);
                $('#addCoop').modal('toggle');
            }
        });
}

dashboard.editListTitle = function(el) {
    el.hide();
    $( 'input[name="cardTitle"][value="'+el.html()+'"]' ).css('display', 'block');
    $( 'input[name="cardTitle"][value="'+el.html()+'"]' ).focus();
}

dashboard.donEditList = function(el) {
    $.get( updateList, { id: el.attr('data-id'), title : el.val()} )
        .done(function(data) {
            el.hide();
            $(".card-title[data-id='"+el.attr('data-id')+"']").show();
            $( "#dashboard-principal" ).load( updateMainDashboard);
        });

}

dashboard.createList = function(el) {
    el.hide();
    $('#listeCreator').show();
}

dashboard.abortList = function()    {
    $('#listeCreator').hide();
    $('#creatorList').show();
}



dashboard.showCardPopover = function(el) {
    var top     = el.offset().top;
    var left    = el.offset().left;

    $('#card-popover').css('display', 'block');
    $('#card-popover').css('top', top);
    $('#card-popover').css('left', left);
    $('#card-popover').focus();

}

dashboard.showChecklistPopover = function (el)  {
    var top     = el.offset().top;
    var left    = el.offset().left;

    $('#checklist-pop').css('display', 'block');
    $('#checklist-pop').css('top', top);
    $('#checklist-pop').css('left', left);
    $('#checklist-pop').focus();
}

dashboard.closePopover = function (el) {
    el.hide();
}

dashboard.addChecklistElements = function (el, id)  {
    $('.checklistForm').hide();
    $('#checklistForm_'+id).show();
}

dashboard.closeChecklistFormElements = function(id) {
    $('#checklistForm_'+id).hide();
}

$(document).on('click', '#sendInviteBtn', function (e) {
    e.preventDefault();
    dashboard.sendInvitation();
});

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
}

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

