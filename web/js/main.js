$(document).ready(function() {

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
            passwordRep: {
                required: "La contraseña es requerida",
                equalTo: "Debe coincidir con la anterior",
                minlength: "Debe tener al menos de {0} caracteres",
                maxlength: "Debe tener como máximo 10 caracteres"
            }
        }
    });  

        $('#aceptarEditarUsuario').on('click', function (event) {
            event.preventDefault();
            $('#emailEdit').prop('disabled', false);
            if($('#formEditUsuario').valid()){
                $('#formEditUsuario').submit();
            }
        });

    $('#aceptarLogin').on('click', function (event) {
        event.preventDefault();
        if($('#form-signin').valid()){
            $('#form-signin').submit();
        }
    });
    
    $('#cambiarPass').on('click', function () {
        var url = $(this).attr('data-path');
        $('#modal-form').find('.modal-content').load(url, function () {
            $('#modal-form').modal();
        })
    });

    $('#serPremium').on('click', function () {
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