$(document).ready(function () {
    $('#saveDesc').css('display', 'none');

    $('#descCart').bind('input propertychange', function () {
        $('#saveDesc').css('display', 'block');
    });

    $('.addCard').click(function () {
       $('#id_card').val($(this).attr('data-card'));
        $('#createCard').modal();
    });

    $('#saveDesc').click(function () {
        $.get( saveCartDetails, { id: $('#id_task').val(), description : $('#descCart').val()} )
            .done(function() {
                $('#saveDesc').css('display', 'none');
                $('#cartDetails').modal('hide');
            });
    });

    $('#addChecklist').click(function () {
       $('#checklistForm').fadeIn();
    });

    $('#cancelChecklist').click(function () {
        $('#checklistForm').fadeOut();
    });

    /*
    Dashboard favorites
     */
    $('#updateFavorite').click(function () {
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

    $('#createEtiquette').click(function () {
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
    });

});

$(document).on('click', '.tasks', function () {
    $('#listChecklist').html('');
    $('#etiqCreate').hide();
    var id_cart = $(this).attr('data-id');
    $.get( cartDetails, { id: id_cart} )
        .done(function( data ) {
            $('#descCart').val(data.description);
            $('#id_task').val(id_cart);
            refreshChecklist(id_cart);
            refreshComments(id_cart);
        });
    $('#task-title').html($(this).attr('data-name'));

    $('.etiqDiv').each(function () {
        $(this).find('i').remove();
    });

    $('.etiqDiv').each(function () {
        var div = $(this);
        $.get( checkEtiquettes, { id_etiquette: $(this).attr('data-id'), id_dashboard_task : id_cart} )
            .done(function( data ) {
                console.log(data);
                if(data.success == true){
                    div.append('<i class="fas fa-check"></i>');
                }
            });
    });

    $('#cartDetails').modal();
});

$(document).on('click', '#saveChecklist', function () {
    $.get( saveCartChecklist, { id_card: $('#id_task').val(), name : $('#checklistText').val(), id_user: $('#id_user').val()} )
        .done(function() {
            $('#checklistForm').fadeOut();
            refreshChecklist($('#id_task').val());
            $( "#dashboard-principal" ).load( updateMainDashboard);
        });
});

$(document).on('click', '#saveComment', function () {
    $.get( saveComments, { id_task: $('#id_task').val(), comment : $('#comment').val(), id_user: $('#id_user').val()} )
        .done(function() {
            $('#comment').val('');
            refreshComments($('#id_task').val());
            $( "#dashboard-principal" ).load( updateMainDashboard);
        });
});

$(document).on('change', '.doneCheck', function () {
    var checkbox = $(this);
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
});

$(document).on('click', '.etiqDiv', function () {
    var id_etiquette = $(this).attr('data-id');
    var task         = $('#id_task').val();
    var element      = $(this);
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
});

function refreshChecklist(id_task){
    $('#listChecklist').html('');
    $.get( getCartChecklist, { id:id_task} )
        .done(function(data) {
            var html = '';
            var count = data.length;
            if(count > 0){
                var progress = 0;
                $.each(data, function (i, v) {

                    if(v.done > 0){
                        progress++;
                        html+= '<input type="checkbox" value="'+ v.id +'" data-cart="'+ id_task +'" class="doneCheck" checked><label style="text-decoration: line-through;">' + v.name + '</label><br>';
                    }else{
                        html+= '<input type="checkbox" value="'+ v.id +'" data-cart="'+ id_task +'" class="doneCheck"><label>' + v.name + '</label><br>';
                    }
                });
                var progressPercent = (progress*100)/count;
                $('#checkProgress').attr('aria-valuenow', progress);
                $('#checkProgress').attr('aria-valuemax', count);
                $('#checkProgress').css('width', progressPercent + '%');
                $('#listChecklist').html(html);
                $('#countCheck').html(data.length);
                $('#doneCheck').html(progress);
            }
        });
}

function refreshComments(id_task){
    $('#listComments').html('');
    $.get( getComments, { id:id_task} )
        .done(function(data) {
            var html = '';
            $.each(data, function (i, v) {

                if(v.id_user !== parseInt($('#id_user').val())){
                    html+= '<div class="alert alert-primary comments" data-id="' + v.id + '" data-user="' + v.id_user +'" disabled>' + v.comment + '</div>';
                }else{
                    html+= '<div class="alert alert-primary comments" data-id="' + v.id + '" data-user="' + v.id_user +'">' + v.comment + '</div>';
                }

            });
            $('#listComments').html(html);
            $('#countCom').html(data.length);
        });
}

function refreshEtiquettes(id_dashboard){

}