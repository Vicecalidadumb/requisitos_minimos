//PAGINACION
//$( document ).ready(function() {
$(".link_1").css('color', '#35aa47');
var pagina = 1;
function cambio_pagina(tipo, num) {
    switch (tipo) {
        case 0:
            pagina--;
            break;
        case 1:
            pagina++;
            break;
        case 3:
            pagina = num;
            break;
    }
    if (pagina == 0) {
        pagina = 1;
    } else if (pagina == 4)
        pagina = 3;
    switch (pagina) {
        case 0:
            window.location = base_url_js + "index.php/aspirantes"
            break;
        case 1:

            $('#anterior').hide();
            $('#siguiente').show();
            $(".link_1").css('color', '#35aa47');
            $(".link_2").css('color', '#000');
            $(".link_3").css('color', '#000');
            $("#formulario_1").show();
            $("#formulario_1_1").show();
            $("#formulario_2").hide();
            $("#formulario_3").hide();
            break;
        case 2:
            $('#siguiente').show();
            $('#anterior').show();
            $(".link_2").css('color', '#35aa47');
            $(".link_3").css('color', '#000');
            $(".link_1").css('color', '#000');
            $("#formulario_1").hide();
            $("#formulario_2").show();
            $("#formulario_3").hide();
            break;
        case 3:
            $('#siguiente').hide();
            $('#anterior').show();
            $(".link_3").css('color', '#35aa47');
            $(".link_2").css('color', '#000');
            $(".link_1").css('color', '#000');
            $("#formulario_1").show();
            $("#formulario_1_1").hide();
            $("#formulario_2").hide();
            $("#formulario_3").show();
            break;
    }
}

$(document).ready(function () {

    $("#formulario_2").hide();
//FIN PAGINACION


    $('.page-container').delegate('.opcion', 'click', function () {
//$('.opcion').click(function() {
//$(".container").delegate(".activar", "click", function() {
        Metronic.blockUI({
            target: '.modal-dialog',
            message: 'Cargando...'
        });
        var accion = $(this).attr('data-accion')
        var titulo = "";
        var url = "";
        var id = "";
        var tipoadj = ""
//        alert()
        switch (accion) {
            case 'editar':
                titulo = '<h5><i class="glyphicon glyphicon-pencil"></i> EDUCACIÓN FORMAL</h5>';
                url = base_url_js + '/index.php/evaluacion/calificar_modalidad';
                $("#remover").removeClass('modal-lg modal-full').addClass('');
                $('#guardar').show();
                tipoadj = $(this).attr('data-tipoadj')
                break;
            case 'editar_exp':
                titulo = '<h5><i class="glyphicon glyphicon-pencil"></i> INGRESO Y ACTUALIZACION DE EXPERIENCIA</h5>';
                url = base_url_js + '/index.php/evaluacion/calificar_experiencia';
                $("#remover").removeClass('modal-lg modal-full').addClass('');
                $('#guardar').show();
                break;
            case 'consultar_opec':
                titulo = '<h3><i class="icon-graduation" style=" font-size:30px"></i> OPEC - Convocatoria:  </h3>';
                url = base_url_js + '/index.php/evaluacion/consultar_opec';
                $("#remover").removeClass('modal-lg modal-full').addClass('modal-lg');
                $('#guardar').hide();
                break;
        }
        $('#contenido').html('')
        if (titulo != '') {
            id = $(this).attr('data-id')
            var idcal = $(this).attr('data-idcal')
            var idperfil = $(this).attr('data-idperfil')
            var requisito = $(this).attr('data-requisito')
            var id_glo = $(this).attr('data-id_glo')
            $.post(url, {id: id, idperfil: idperfil, idcal: idcal, requisito: requisito, id_glo: id_glo, tipoadj: tipoadj})
                    .done(function (msg) {
                        Metronic.unblockUI('.modal-dialog');
                        $('#contenido').html(msg)
                    }).fail(function (msg) {
                $.notific8('Error al traer la información', {
                    horizontalEdge: 'bottom',
                    theme: 'ruby',
                    heading: 'ERROR',
                    sticky: false
                });
                Metronic.unblockUI('.modal-dialog');
            })

//        var recipient = button.data('id') 
            var modal = $(this)
            $('.modal-title').html(titulo)
        } else {
//return false;
        }
    });
    $('#guardar_rm').click(function () {
        var r = confirm('Desea Guardar Todos Los datos')
        if (r == true) {
            var url = base_url_js + "index.php/evaluacion/guardar_form_final";
            Metronic.blockUI({
                target: '.no-js',
                message: 'Cargando...'
            });
            $.post(url, $('#form_final').serialize())
                    .done(function (msg) {
                        Metronic.unblockUI('.no-js');
                        UINotific8.init();
                        $.notific8('Los Datos en Formacion Fueron Guardados.', {
                            horizontalEdge: 'bottom',
                            life: 5000,
                            theme: 'amethyst',
                            heading: 'EXITO'
                        });
                        if (msg == "No Admitido") {
                            $("#noo").show();
                            $("#sii").hide();
                        } else if (msg == "Admitido") {
                            $("#sii").show();
                            $("#noo").hide();
                        }

                        $('#guardar_calificacion').show();
                    }).fail(function () {
                Metronic.unblockUI('.no-js');
                $.notific8('Error en la Base de datos', {
                    horizontalEdge: 'bottom',
                    theme: 'ruby',
                    heading: 'ERROR',
                    sticky: false
                });
            })
        }
    });
    $('#guardar_calificacion').click(function () {
        var r = confirm('Desea Guardar Todos Los datos')
        if (r == true) {
            var url = base_url_js + "index.php/evaluacion/guardar_calificacion";
            var id_glo = $(this).attr('id_glo')
            var tex_obs_super = $('#tex_obs_super').val();
            Metronic.blockUI({
                target: '.no-js',
                message: 'Cargando...'
            });
            $.post(url, {id_glo: id_glo, tex_obs_super: tex_obs_super})
                    .done(function (msg) {
                        Metronic.unblockUI('.no-js');
                        UINotific8.init();
                        $.notific8('Los Datos en Formacion Fueron Guardados.', {
                            horizontalEdge: 'bottom',
                            life: 5000,
                            theme: 'amethyst',
                            heading: 'EXITO'
                        });
                        var url = base_url_js + "index.php/aspirantes";
                        window.location = url;
                        $('#guardar_calificacion').show();
                    }).fail(function () {
                Metronic.unblockUI('.no-js');
                $.notific8('Error en la Base de datos', {
                    horizontalEdge: 'bottom',
                    theme: 'ruby',
                    heading: 'ERROR',
                    sticky: false
                });
            })
        }
    })
    $('#anterior').hide();
});
