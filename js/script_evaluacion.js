//PAGINACION
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
    switch (pagina) {
        case 0:
            window.location = base_url_js + "index.php/aspirantes"
            break;
        case 1:
            $("#formulario_1").show();
            $("#formulario_2").hide();
            $("#formulario_3").hide();
            break;
        case 2:
            $("#formulario_1").hide();
            $("#formulario_2").show();
            $("#formulario_3").hide();
            break;
        case 3:
            $("#formulario_1").hide();
            $("#formulario_2").hide();
            $("#formulario_3").show();
            break;
    }
}
$("#formulario_2").hide();
//FIN PAGINACION


$('.opcion').click(function() {
//$(".container").delegate(".activar", "click", function() {

    var accion = $(this).attr('data-accion')
    var titulo = "";
    var url = "";
    var id = "";
    switch (accion) {
        case 'editar':
            titulo = '<h5><i class="glyphicon glyphicon-pencil"></i> EDUCACIÓN FORMAL</h5>';
            url = base_url_js + '/index.php/evaluacion/calificar_modalidad';
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
    if (titulo != '') {
        $('#contenido').html('')
        id = $(this).attr('data-id')
        var idcal = $(this).attr('data-idcal')

        $.post(url, {id: id,idcal: idcal})
                .done(function(msg) {
                    $('#contenido').html(msg)
                }).fail(function(msg) {
            alert('Error al traer la información');
        })

//        var recipient = button.data('id') 
        var modal = $(this)
        $('.modal-title').html(titulo)
    } else {
        //return false;
    }
});