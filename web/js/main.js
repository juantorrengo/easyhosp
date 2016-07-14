$(document).ready(function() {
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    });

    blockStyle = {
        message: '',
        overlayCSS: { backgroundColor: '#fff', opacity:0 }
    }

    $('#forgetPassCard').hide();
    
    $('#form-signin').validate({
        rules: {
            username: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 10
            }
        },
        messages: {
            username: {
                required: "El nombre de usuario es requerido",
                email: "Debe ser su email"
            },
            password: {
                required: "La contraseña es requerida",
                minlength: "Debe tener al menos 6 caracteres",
                maxlength: "Debe tener como máximo 10 caracteres"
            }
        }
    });

    $('#form-recuPass').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "El email es requerido",
                email: "Debe ser su email"
            }
        }
    });

    $('#formNewPassRecuperada').validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                maxlength: 10
            },
            passwordRep: {
                required: true,
                equalTo: "#passwordRecuperada",
                minlength: 6,
                maxlength: 10
            }
        },
        messages: {
            password: {
                required: "La contraseña es requerida",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            passwordRep: {
                required: "La contraseña es requerida",
                equalTo: "Debe coincidir con la anterior",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "Debe tener como máximo 10 caracteres"
            }
        }
    });

    $('#formRegistro').validate({
        rules: {
            nombre: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            apellido: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            email: {
                required: true,
                email: true
            },
            direccion: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            telefono: {
                required: true,
                minlength: 10,
                digits: true
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 10
            },
            passwordRep: {
                required: true,
                equalTo: "#password",
                minlength: 6,
                maxlength: 10
            }
        },
        messages: {
            nombre: {
                required: "El nombre es requerido",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            apellido: {
                required: "El apellido es requerido",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            email: {
                required: "El email es requerido",
                email: "Debe ser un email válido"
            },
            direccion: {
                required: "La dirección es requerida",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            telefono: {
                required: "El teléfono es requerido",
                minlength: "El teléfono de tener al menos {0} caracteres numéricos",
                digits: "Solo se aceptan caracteres numéricos"
            },
            password: {
                required: "La contraseña es requerida",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            passwordRep: {
                required: "La contraseña es requerida",
                equalTo: "Debe coincidir con la anterior",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "Debe tener como máximo 10 caracteres"
            }
        }
    });


    $('#formEditUsuario').validate({
        rules: {
            nombre: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            apellido: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            email: {
                required: true,
                email: true
            },
            direccion: {
                required: true,
                minlength: 3,
                maxlength: 30
            },
            telefono: {
                required: true,
                minlength: 10,
                digits: true
            },
            dni: {
                required: false,
                maxlength: 8,
                minlength: 7,
                digits: true
            },
            sexo: {
                required: false,
                maxlength: 8,
            },
            contActual: {
                required: true,
                equalTo: "#checkPassAct",
                minlength: 6,
                maxlength: 10
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 10
            },
            passwordRep: {
                required: true,
                equalTo: "#password",
                minlength: 6,
                maxlength: 10
            }
        },
        messages: {
            nombre: {
                required: "El nombre es requerido",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            apellido: {
                required: "El apellido es requerido",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            email: {
                required: "El email es requerido",
                email: true
            },
            direccion: {
                required: "La dirección es requerida",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            telefono: {
                required: "El teléfono es requerido",
                minlength: "El teléfono de tener al menos {0} caracteres numéricos",
                digits: "Solo se aceptan caracteres numéricos"
            },
            contActual: {
                required: "La contraseña actual es requerida",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres",
                equalTo: "La contraseña actual es incorrecta"
            },
            password: {
                required: "La contraseña es requerida",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "No puede tener más de {0} caracteres"
            },
            dni: {
                digits: "Solo se aceptan caracteres numéricos",
                maxlength: "No puede tener más de {0} caracteres",
                minlength: "Debe tener al menos de {0} caracteres"
            },
            passwordRep: {
                required: "La contraseña es requerida",
                equalTo: "Debe coincidir con la anterior",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "Debe tener como máximo 10 caracteres"
            }
        }
    });
    var desde, hasta, dias;
    $(function() {
        function getCurrentDate() {
            var d = new Date();

            var month = d.getMonth()+1;
            var day = d.getDate();
            var date = ((''+month).length<2 ? '0' : '') + month +'/' +
                ((''+day).length<2 ? '0' : '') + day + '/' + d.getFullYear();
            return date;
        }

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
            },
            minDate: getCurrentDate()
        });

        fullDisabled($('#btnSearchHosp'));

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            desde = picker.startDate.format('YYYY-MM-DD');
            hasta = picker.endDate.format('YYYY-MM-DD');
            $('#desde').val(desde);
            $('#hasta').val(hasta);
            fullEnabled($('#btnSearchHosp'));
           
        });
        $('input[name="datefilter"]').on('change', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            fullDisabled($('#btnSearchHosp'));
        });
    });

    $('#msgConfirmReserva').hide();

    // LOGIN ,RECUPERO y USUARIO
    $('#aceptarLogin').on('click', function (event) {
        event.preventDefault();
        if($('#form-signin').valid()){
            $('#form-signin').submit();
        }
    });

    $('#aceptarRecuPass').on('click', function (event) {
        event.preventDefault();
        if($('#form-recuPass').valid()){
            var email = $('#emailRecu').val();
            var url = $(this).attr('data-path');
            url = url.replace('x', email);
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
        }
    });

    $('#recuperarPass').on('click', function (event) {
        $('#loginCard').hide();
        $('#forgetPassCard').show();
    });

    $('#cancelarRecuPass').on('click', function (event) {
        $('#forgetPassCard').hide();
        $('#loginCard').show();
    });

    $('#cambiarPass').on('click', function () {
        var url = $(this).attr('data-path');
        $('#modal-form').find('.modal-content').load(url, function () {
            $('#modal-form').modal();
        })
    });

    $('#aceptarRecuperarPass').on('click', function (event) {
        event.preventDefault();
        if($('#formNewPassRecuperada').valid()){
            $('#formNewPassRecuperada').submit();
        }
    });

    $('#aceptarEditarUsuario').on('click', function (event) {
        event.preventDefault();
        $('#emailEdit').prop('disabled', false);
        if($('#formEditUsuario').valid()){
            $('#formEditUsuario').submit();
        }
    });

    $('#serPremium').on('click', function () {
        var url = $(this).attr('data-path');
        $('#modal-form').find('.modal-content').load(url, function () {
            $('#modal-form').modal();
        })
    });

    $('#recuperarPass').on('click', function () {
        var url = $(this).attr('data-path');
        $('#modal-form').find('.modal-content').load(url, function () {
            $('#modal-form').modal();
        })
    });

    $('#aceptarNuevoRegistro').on('click', function (event) {
        event.preventDefault();
        if($('#formRegistro').valid()){
            $('#formRegistro').submit();
        }
    });

    //MIS PUBLICACIONES

    $('#btnNuevoHosp').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('data-path');
        $('#modal-form').find('.modal-content').load(url, function () {
            $('#modal-form').modal();
        });
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

    // EDITAR HOSPEDAJE
    $('.btnEditHosp').on('click', function (e) {
        e.preventDefault();
        var idHosp = $(this).find('.idHospedaje').val();
        var url = $(this).attr('data-path');
        url = url.replace('x', idHosp);
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
    // ELIMINAR HOSPEDAJE

    $('.btnDeleteHosp').on('click', function () {
        var idHosp = $(this).find('.idHosp').val();
        var url = $(this).attr('data-path');
        url = url.replace('x', idHosp);
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

    // HABILITAR HOSPEDAJE

    $('.btnHabilitarHosp').on('click', function () {
        var idHosp = $(this).find('.idHosp').val();
        var url = $(this).attr('data-path');
        url = url.replace('x', idHosp);
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

});//Fin ready


//HOSPEDAJES

var tablaHospedajes = $('#tablaHospedajes');

$('#btnSearchHosp').on('click', function (e) {
    e.preventDefault();
    if($('#desde').val()=="" || $('#hasta').val()==""){
        alert('Ingrese una fecha válida.');
        return;
    }
    tablaHospedajes.block(blockStyle);
    $.ajax({
        url: Routing.generate('searchHosp'),
        data: $('#searchForm').serialize(),
        success: function (data) {
            if(data.status == 400){
                $('#ajaxAlerts').find('.close').next().html(data.msg);
                $('#ajaxAlerts').show();
                tablaHospedajes.unblock();
            }else{
                tablaHospedajes.html(data);
                tablaHospedajes.unblock();
            }
        }
    });
});

tablaHospedajes.on('click', '.verDetalle', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-path');
    var desde = $('#desde').val();
    var hasta = $('#hasta').val();
    $.ajax({
        url: Routing.generate('detalleHosp', {'id':id, 'desde':desde, 'hasta':hasta}),
        success: function (data) {
            if(data.status == 400){
                $('#ajaxAlerts').find('.close').next().html(data.msg);
            }else{
                $('#modal-form').find('.modal-content').html(data);
                $('#modal-form').modal();
            }
        }
    });
});


tablaHospedajes.on('click', '.markFav', function (e) {
    e.preventDefault();
    tablaHospedajes.block(blockStyle);
    var self = $(this);
    var hospId = self.attr('data-ref');
    $.ajax({
        url: Routing.generate('marcarFav', {'id': hospId}),
        success: function (data) {
            if(data.status == 400){
                $('#ajaxAlerts').find('.close').next().html(data.msg);
                tablaHospedajes.unblock();
            }else{
                marcarFav(self);
                tablaHospedajes.unblock();
            }
        }
    });
});

tablaHospedajes.on('click', '.unmarkFav', function (e) {
    e.preventDefault();
    tablaHospedajes.block(blockStyle);
    var self = $(this);
    var hospId = self.attr('data-ref');
    $.ajax({
        url: Routing.generate('desmarcarFav', {'id': hospId}),
        success: function (data) {
            if(data.status == 400){
                $('#ajaxAlerts').find('.close').next().html(data.msg);
                tablaHospedajes.unblock();
            }else{
                desmarcarFav(self);
                tablaHospedajes.unblock();
            }
        }
    });
});

//USUARIOS

var tablaUsuarios = $('#tablaUsuarios');

$('.bajaUsuario').on('click', function (e) {
    e.preventDefault();
    tablaUsuarios.block(blockStyle);
    $.ajax({
        url:Routing.generate('msgBaja', {'id': $(this).attr('data-path')}),
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

var tablaCalificaciones = $('#tablaCalificaciones');

$('#califRecibidas').on('click', function (e) {
    e.preventDefault();
    tablaCalificaciones.block(blockStyle);
    setAsActive($(this), $('#navCal'));
    $.ajax({
        url:Routing.generate('misCalificacionesAjax'),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
                tablaCalificaciones.unblock();
            }else{
                tablaCalificaciones.html(data);
                tablaCalificaciones.unblock();
            }
        }
    });
});

$('#califRecibidasHosp').on('click', function (e) {
    e.preventDefault();
    tablaCalificaciones.block(blockStyle);
    setAsActive($(this), $('#navCal'));
    $.ajax({
        url:Routing.generate('recibidasHospedajes'),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
                tablaCalificaciones.unblock();
            }else{
                tablaCalificaciones.html(data);
                tablaCalificaciones.unblock();
            }
        }
    });
});

$('#califHechasHosp').on('click', function (e) {
    e.preventDefault();
    tablaCalificaciones.block(blockStyle);
    setAsActive($(this), $('#navCal'));
    $.ajax({
        url:Routing.generate('dadasAHospedajes'),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
                tablaCalificaciones.unblock();
            }else{
                tablaCalificaciones.html(data);
                tablaCalificaciones.unblock();
            }
        }
    });
});

$('#califHechasHuespedes').on('click', function (e) {
    e.preventDefault();
    tablaCalificaciones.block(blockStyle);
    setAsActive($(this), $('#navCal'));
    $.ajax({
        url:Routing.generate('dadasAHuespedes'),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
                tablaCalificaciones.unblock();
            }else{
                tablaCalificaciones.html(data);
                tablaCalificaciones.unblock();
            }
        }
    });
});



//RESERVAS

var tablaReservas = $('#tablaReservas');


$('#reservasParaConfirmar').on('click', function (e) {
    e.preventDefault();
    tablaReservas.block(blockStyle);
    setAsActive($(this), $('#navRes'));
    $.ajax({
        url:Routing.generate('resSinConf'),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
                tablaReservas.unblock();
            }else{
                tablaReservas.html(data);
                tablaReservas.unblock();
            }
        }
    });
});

$('#misReservasFin').on('click', function (e) {
    e.preventDefault();
    tablaReservas.block(blockStyle);
    setAsActive($(this), $('#navRes'));
    $.ajax({
        url:Routing.generate('resFinalizadas'),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
                tablaReservas.unblock();
            }else{
                tablaReservas.html(data);
                tablaReservas.unblock();
            }
        }
    });
});

$('#misReservas').on('click', function (e) {
    e.preventDefault();
    tablaReservas.block(blockStyle);
    setAsActive($(this), $('#navRes'));
    $.ajax({
        url:Routing.generate('misReservasAjax'),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
                tablaReservas.unblock();
            }else{
                tablaReservas.html(data);
                tablaReservas.unblock();
            }
        }
    });
});


tablaReservas.on('click', '.calificar', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-path');
    $.ajax({
        url: Routing.generate('formCalificar', {'id':id}),
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

tablaReservas.on('click', '.calificarHuesp', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-path');
    $.ajax({
        url: Routing.generate('formCalificarHuesp', {'id':id}),
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


tablaReservas.on('click', '.confirmar', function (e) {
    e.preventDefault();
    $.ajax({
        url:Routing.generate('msgConRes', {'id':$(this).attr('data-path')}),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
            }else{
                $('#modal-form').find('.modal-content').html(data);
                $('#modal-form').modal();
            }
        }
    })
});

tablaReservas.on('click', '.rechazar', function (e) {
    e.preventDefault();
    $.ajax({
        url:Routing.generate('msgRechRes', {'id':$(this).attr('data-path')}),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
            }else{
                $('#modal-form').find('.modal-content').html(data);
                $('#modal-form').modal();
            }
        }
    })
});

tablaReservas.on('click', '.verDetalles', function(e){
    e.preventDefault();
    var resId = $(this).attr('data-path');
    $.ajax({
        url:Routing.generate('detallesReserva', {'id': resId}),
        success: function (data) {
            if(data.status == 400){
                alert(data.msg);
            }else{
                $('#modal-form').find('.modal-content').html(data);
                $('#modal-form').modal();
            }
        }
    })
});

function marcarFav(elem){
    elem.addClass('unmarkFav');
    elem.addClass('fa-star');
    elem.removeClass('fa-star-o');
    elem.removeClass('markFav');
}

function desmarcarFav(elem){
    elem.removeClass('fa-star');
    elem.removeClass('unmarkFav');
    elem.addClass('fa-star-o');
    elem.addClass('markFav');
}

function fullDisabled(elem){
    elem.prop('disabled', true);
}

function fullEnabled(elem){
    elem.prop('disabled', false);
}

function setAsActive(elem, div){
    var prev = div.find('.active');
    elem.parent().addClass('active');
    prev.removeClass('active');
}