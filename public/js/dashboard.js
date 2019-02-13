$(document).ready(function () {
    $('#saveDesc').css('display', 'none');
    $('.tasks').click(function () {
        $('#listChecklist').html('');
        var id_cart = $(this).attr('data-id');
        $.get( cartDetails, { id: id_cart} )
            .done(function( data ) {
                $('#descCart').val(data.description);
                $('#id_task').val(id_cart);
                refreshChecklist(id_cart);
                refreshComments(id_cart);
            });
        $('#task-title').html($(this).attr('data-name'));

        $('#cartDetails').modal();
    });

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

    $('#saveChecklist').click(function () {
        $.get( saveCartChecklist, { id_card: $('#id_task').val(), name : $('#checklistText').val(), id_user: $('#id_user').val()} )
            .done(function() {
                $('#checklistForm').fadeOut();
                refreshChecklist($('#id_task').val());
            });
    });

    $('#saveComment').click(function () {
        $.get( saveComments, { id_task: $('#id_task').val(), comment : $('#comment').val(), id_user: $('#id_user').val()} )
            .done(function() {
                $('#comment').val('');
                refreshComments($('#id_task').val());
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
});

$(document).on('change', '.doneCheck', function () {
    var checkbox = $(this);
    if(checkbox.is(':checked')){
        $.get( updateChecklist, { id: checkbox.val(), value : 1} )
            .done(function() {
                $('#checklistForm').fadeOut();
                refreshChecklist(checkbox.attr('data-cart'));
            });
    }else{
        $.get(  updateChecklist, { id: checkbox.val(), value : 0} )
            .done(function() {
                $('#checklistForm').fadeOut();
                refreshChecklist(checkbox.attr('data-cart'));
            });
    }
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