$(document).ready(function() {
    $('#login').on('click', function (event) {
        event.preventDefault();
        var url = $('#loginPath').attr('data-path');
        $('#modal-form').find('.modal-content').load(url, function () {
            $('#modal-form').modal();
        });
    });

    $('.carousel').carousel({
        interval: 5000 //changes the speed
    });

    //TIPO HOSPEDAJE

    $('#btnNuevoTipo').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('data-path');
        $('#modal-form').find('.modal-content').load(url, function () {
            $('#modal-form').modal();
        });
    });

    $('.btnEditTipoHosp').on('click', function (e) {
        e.preventDefault();
        var idTipo = $(this).find('.idTipo').val();
        var url = $(this).attr('data-path');
        url = url.replace('x', idTipo);
        $.ajax({
            url: url,
            success: function (data) {
                if(data.status == 400){
                    alert(data.msg);
                }else{
                    $('#modal-form').find('.modal-content').html(data);
                    $('#modal-form').modal();
                }
            }
        });
    });
    
    $('.btnVerTipoHosp').on('click', function () {
        var id = $(this).find('.idTipo').val();
        var url = $(this).attr('data-path');
        $('#login-modal').load(url, function () {
            $('#login-modal').modal();
        });
    });

    $('.btnDeleteTipoHosp').on('click', function () {
        var idTipo = $(this).find('.idTipo').val();
        var url = $(this).attr('data-path');
        url = url.replace('x', idTipo);
        $.ajax({
            url: url,
            success: function (data) {
                if(data.status == 400){
                    alert(data.msg);
                }else{
                    $('#modal-form').find('.modal-content').html(data);
                    $('#modal-form').modal();
                }
            }
        });
    });

});