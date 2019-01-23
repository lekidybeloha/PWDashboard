$(document).ready(function () {
    $('#saveDesc').css('display', 'none');
    $('.tasks').click(function () {
        var id_cart = $(this).attr('data-id');
        $.get( cartDetails, { id: id_cart} )
            .done(function( data ) {
                $('#descCart').val(data.description);
                $('#id_task').val(id_cart);
            });
        $('#task-title').html($(this).attr('data-name'));

        $('#cartDetails').modal();
    });

    $('#descCart').bind('input propertychange', function () {
        $('#saveDesc').css('display', 'block');
    });

    $('#saveDesc').click(function () {
        $.get( saveCartDetails, { id: $('#id_task').val(), description : $('#descCart').val()} )
            .done(function() {
                $('#saveDesc').css('display', 'none');
                $('#cartDetails').modal('hide');
            });
    });
})