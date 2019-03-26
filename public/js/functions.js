function refreshChecklist(id_task){
    $('#checklist-overlay').html('');
    var html = '';
    var attributes = [];
    $.get( getCartChecklistName, { id_cart:id_task} )
        .done(function(res) {
            if(res.length > 0){
                $.each(res, function (index, val) {
                    html += '<label style="display: inline-flex;">' + val.name + '</label><button class="btn button-grey" style="float: right">Supprimer</button>';
                    jQuery.ajaxSetup({async:false});
                    $.get( getCartChecklist, { id:id_task, name : val.id} ,)
                        .done(function(data) {
                            var count = data.length;
                            console.log(data);
                            if(data.length > 0){
                                html += '<div class="progress">' +
                                    '    <div class="progress-bar" id="progress_'+ data[0].id +'" role="progressbar" aria-valuenow="'+ data[0].id +'" aria-valuemin="0" aria-valuemax="'+ count +'" style="width:0%">' +
                                    '    </div>' +
                                    '  </div>';
                            }/*else{
                                html += '<div class="progress">' +
                                    '    <div class="progress-bar" id="progress_'+ data[0].id +'" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="1" style="width:0%">' +
                                    '    </div>' +
                                    '  </div>';
                            }*/

                            if(count > 0){
                                var progress = 0;
                                $.each(data, function (i, v) {

                                    if(v.done > 0){
                                        progress++;
                                        html+= '<input type="checkbox" value="'+ v.id +'" data-cart="'+ id_task +'" class="doneCheck" checked onchange="dashboard.doneChecklist($(this))"><label style="text-decoration: line-through;display: inline-flex; margin-left: 15px">' + v.name + '</label><br>';
                                    }else{
                                        html+= '<input type="checkbox" value="'+ v.id +'" data-cart="'+ id_task +'" class="doneCheck" onchange="dashboard.doneChecklist($(this))"><label style="display: inline-flex; margin-left: 15px;">' + v.name + '</label><br>';
                                    }
                                });
                                var progressPercent = (progress*100)/count;
                                if(data.length > 0){
                                    attributes.push({progress : data[0].id, max : count, percent : progressPercent, now : progress});
                                }

                            }

                        });
                    html += '<div id="checklistForm_'+ val.id +'" class="checklistForm" style="display: none;">' +
                        '                                <input type="text" value="" id="textCheck_'+val.id+'" name="name" class="form-control">\n' +
                        '                                <input type="hidden" value="" name="id_user" id="id_user">' +
                        '                                <button class="btn btn-success" id="saveChecklist" onclick="dashboard.saveChecklist('+val.id+')">Enregistrer</button>' +
                        '                                <a href="#" onclick="dashboard.closeChecklistFormElements('+val.id+')">X</a>' +
                        '                            </div>'
                    html += '<button class="btn button-grey" onclick="dashboard.addChecklistElements($(this), '+ val.id +')">Ajouter un élément</button><br>';
                });
                $('#checklist-overlay').html(html);
                $.each(attributes, function (ind, val) {
                    $('#progress_'+val.progress).attr('aria-valuenow', val.now);
                    $('#progress_'+val.progress).attr('aria-valuemax', val.maw);
                    $('#progress_'+val.progress).css('width', val.percent + '%');
                })
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

