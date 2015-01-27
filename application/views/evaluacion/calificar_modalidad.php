<?php
if (count($datos)) {
    $IDMODALIDAD_MOD = $datos[0]->IDMODALIDAD_MOD;
    $MODALIDAD_MOD = $datos[0]->MODALIDAD_MOD;
    $SEMESTRES_EDF = $datos[0]->SEMESTRES_EDF;
    $TITULOEXTRANJERO_EDF = $datos[0]->TITULOEXTRANJERO_EDF;
    $IDUNIVERSIDAD_UNIV = $datos[0]->IDUNIVERSIDAD_UNIV;
    $UNIVERSIDAD_UNIV = $datos[0]->UNIVERSIDAD_UNIV;
    $IDTITULO_TIT = $datos[0]->IDTITULO_TIT;
    $TITULO_TIT = $datos[0]->TITULO_TIT;
    $FECHATERMINACION_EDF = explode(" ", $datos[0]->FECHATERMINACION_EDF);
    $FECHATERMINACION_EDF = $FECHATERMINACION_EDF[0];
    $FECHA_EDF = explode(" ", $datos[0]->FECHA_EDF);
    $FECHA_EDF = $FECHA_EDF[0];
    $OBSERVACION = $datos[0]->OBSERVACION;
} else {
    $IDMODALIDAD_MOD = "";
    $MODALIDAD_MOD = "";
    $SEMESTRES_EDF = "";
    $TITULOEXTRANJERO_EDF = "";
    $IDUNIVERSIDAD_UNIV = "-1";
    $UNIVERSIDAD_UNIV = "";
    $IDTITULO_TIT = "-1";
    $TITULO_TIT = "";
    $FECHATERMINACION_EDF = "";
    $FECHA_EDF = "";
    $OBSERVACION = "";
}
?>


<form method="post" id="form1" >
    <input type="hidden" value="<?php echo $post['id'] ?>" id="id" name="id">
    <input type="hidden" value="<?php echo $post['idcal'] ?>" id="idcal" name="idcal">
    <input type="hidden" value="<?php echo $post['id_glo'] ?>" id="id_glo" name="id_glo">
    <input type="hidden" value="<?php echo $post['tipoadj'] ?>" id="tipoadj" name="tipoadj">

    <div class="row">
        <div class="col-md-12 col-sm-12" >
            <table class="table table-bordered table-striped">
                <tr>
                    <td>
                        Requisito Mínimo
                    </td>
                    <td>
                        <?php echo form_checkbox("r_minimo", "1", (($post['requisito'] == 1) ? true : false), "id='r_minimo'") ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Modalidad
                    </td>
                    <td>
                        <?php echo form_dropdown($data = "modalidad", $modalidad, $IDMODALIDAD_MOD, $extra = 'class="form-control input-sm " id="modalidad"') ?>
                        <?php echo form_dropdown($data = "sem", array("0" => "sem", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12"), $SEMESTRES_EDF, $extra = 'class="form-control input-sm " id="sem"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Graduado 
                        &nbsp;&nbsp;&nbsp;
                        <?php echo form_checkbox("graduado", "1", (($SEMESTRES_EDF == 20) ? true : false), "id='graduado' onclick='activar();'") ?>
                    </td>
                    <td>
                        Obtenido en el Extranjero 
                        &nbsp;&nbsp;&nbsp;
                        <?php echo form_checkbox("graduado_ext", "1", (($TITULOEXTRANJERO_EDF == 1) ? true : false), 'id="graduado_ext"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Universidad o Institución
                    </td>
                    <td>
                        <?php echo form_dropdown($data = "universidad", array($IDUNIVERSIDAD_UNIV => $UNIVERSIDAD_UNIV,"-1"=>"Seleccione"), '', $extra = 'id="universidad" class="form-control input-sm "') ?>
                        <table width="100%" id="universidad_otra2">
                            <tr>
                                <td><?php echo form_input("universidad_otra", '', $extra = 'class="form-control input-sm" id="universidad_otra"') ?></td>
                                <td align="center"><button id="guardar_uni" class="btn btn-xs green">Guardar</button></td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr>
                    <td>
                        Título
                    </td>
                    <td>
                        <?php echo form_dropdown($data = "titulo", array($IDTITULO_TIT => $TITULO_TIT,"-1"=>"Seleccione"), '', $extra = 'class="form-control input-sm" id="titulo"') ?>
                        <table width="100%" id="titulo_otra2">
                            <tr>
                                <td><?php echo form_input("titulo_otra", '', $extra = 'class="form-control input-sm" id="titulo_otra"') ?></td>
                                <td align="center"><button id="guardar_titulo" class="btn btn-xs green">Guardar</button></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha Terminación 	
                    </td>
                    <td>
                        <?php echo form_input("fecha_terminacion", $FECHATERMINACION_EDF, $extra = 'class="form-control input-sm fecha" id="fecha_terminacion"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha Grado
                    </td>
                    <td>
                        <?php echo form_input('fecha_grado', $FECHA_EDF, $extra = 'class="form-control input-sm fecha" id="fecha_grado"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Observaciones
                    </td>
                    <td>
                        <?php echo form_textarea('observaciones', $OBSERVACION, $extra = 'style="width: 100%; height: 75px;" class="form-control input-sm "') ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php if ($userdata['ID_TIPO_USU'] == 6) { ?>
                            <button type="button" class="btn btn-success" id="guardar">Guardar</button>
                        <?php } ?>

                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>
<script>
    $('#guardar_uni').click(function() {
        Metronic.blockUI({
            target: '.modal-dialog',
        });
        var universidad_otra = $('#universidad_otra').val()
        if (universidad_otra == "") {
            $.notific8('Dato de Universidad Incompleto', {
                horizontalEdge: 'bottom',
                theme: 'ruby',
                heading: 'ERROR',
                sticky: false
            });
            Metronic.unblockUI('.modal-dialog');
            return false;
        }
        var modalidad = $('#modalidad').val()
        var universidad = $('#modalidad').val()
        var url = '<?php echo base_url('index.php'); ?>/evaluacion/nueva_universidad';
        $.post(url, {universidad_otra: universidad_otra, modalidad: modalidad, universidad: universidad})
                .done(function(msg) {
                    $('#universidad').html(msg);
                    $('#titulo').html('');
                    $('#universidad_otra').val('');
                    $.notific8('Los Datos en Formacion Fueron Guardados.', {
                        horizontalEdge: 'bottom',
                        life: 5000,
                        theme: 'amethyst',
                        heading: 'EXITO'
                    });
                    $('#universidad_otra2').hide();
                    Metronic.unblockUI('.modal-dialog');
                }).fail(function(msg) {
            $.notific8('Error en la Base de Datos', {
                horizontalEdge: 'bottom',
                theme: 'ruby',
                heading: 'ERROR',
                sticky: false
            });
            Metronic.unblockUI('.modal-dialog');
        })

        return false;
    });
    $('#guardar_titulo').click(function() {
        var titulo_otra = $('#titulo_otra').val()
        if (titulo_otra == "") {
            $.notific8('Dato de Titulo Incompleto', {
                horizontalEdge: 'bottom',
                theme: 'ruby',
                heading: 'ERROR',
                sticky: false
            });
            return false;
        }
        var universidad = $('#universidad').val();
        var titulo = $('#universidad').val();
        var url = '<?php echo base_url('index.php'); ?>/evaluacion/nuevo_titulo';
        Metronic.blockUI({
            target: '.modal-dialog',
        });
        $.post(url, {titulo_otra: titulo_otra, universidad: universidad, titulo: titulo})
                .done(function(msg) {
                    $('#titulo').html(msg);
                    $('#titulo_otra').val('');
                    $.notific8('Los datos fueron Guardados con Exito.', {
                        horizontalEdge: 'bottom',
                        life: 5000,
                        theme: 'amethyst',
                        heading: 'EXITO'
                    });
                    $('#titulo_otra2').hide();
                    Metronic.unblockUI('.modal-dialog');
                }).fail(function(msg) {
            $.notific8('Error en la Base de Datos', {
                horizontalEdge: 'bottom',
                theme: 'ruby',
                heading: 'ERROR',
                sticky: false
            });
            Metronic.unblockUI('.modal-dialog');
        })

        return false;
    });
    $('#titulo').change(function() {
        var titulo = $('#titulo option:selected').text();
        if (titulo == 'OTRO') {
            $('#titulo_otra2').show();
            return false;
        } else {
            $('#titulo_otra2').hide();
        }
    });
    $(".fecha").datepicker({
        format: 'yyyy/mm/dd',
        rtl: Metronic.isRTL(),
        orientation: "left",
        autoclose: true,
    });
    function activar() {
        var chek = $('#graduado').is(':checked')
        if (chek == true) {
            $('#sem').hide();
            $('#fecha_grado').show();
        } else {
            $('#sem').show();
            $('#fecha_grado').hide();
        }
    }
    $('#fecha_grado').hide();
    $('#universidad_otra2').hide();
    $('#titulo_otra2').hide();

    $('#modalidad').change(function() {
        var universidad = $(this).val();
        if (universidad == -1)
            return false;
        var url = '<?php echo base_url('index.php'); ?>/evaluacion/universidad';
        Metronic.blockUI({
            target: '.modal-dialog',
        });
        $.post(url, {universidad: universidad})
                .done(function(msg) {
                    $('#universidad').html(msg);
                    $('#titulo').html('');
                    Metronic.unblockUI('.modal-dialog');
                }).fail(function(msg) {
            $.notific8('Error en la Base de Datos', {
                horizontalEdge: 'bottom',
                theme: 'ruby',
                heading: 'ERROR',
                sticky: false
            });
            Metronic.unblockUI('.modal-dialog');
        });
    });
    $('#universidad').change(function() {
        var titulo = $('#universidad option:selected').text();
        if (titulo == 'OTRA') {
            $('#universidad_otra2').show();
            return false;
        } else {
            $('#universidad_otra2').hide();
        }
        var titulo = $(this).val();
        if (titulo == -1 && titulo != 738)
            return false;
        var url = '<?php echo base_url('index.php'); ?>/evaluacion/titulo';
        Metronic.blockUI({
            target: '.modal-dialog',
        });
        $.post(url, {titulo: titulo})
                .done(function(msg) {
                    $('#titulo').html(msg);
                    Metronic.unblockUI('.modal-dialog');
                }).fail(function(msg) {
            $.notific8('Error en la Base de Datos', {
                horizontalEdge: 'bottom',
                theme: 'ruby',
                heading: 'ERROR',
                sticky: false
            });
            Metronic.unblockUI('.modal-dialog');
        });
    });
    $('#guardar').click(function() {
        var i = 0;
        if (i == 0) {
            var titulo = $('#titulo option:selected').text();
            if (titulo == 'OTRO') {
                $.notific8('Valor del Titulo no es Correcto', {
                    horizontalEdge: 'bottom',
                    theme: 'ruby',
                    heading: 'ERROR',
                    sticky: false
                });
                return false
            }
            var titulo = $('#universidad option:selected').text();
            if (titulo == 'OTRA') {
                $.notific8('Valor del Titulo no es Correcto', {
                    horizontalEdge: 'bottom',
                    theme: 'ruby',
                    heading: 'ERROR',
                    sticky: false
                });
                return false
            }

            var modalidad = $('#modalidad').val();
            var sem = $('#sem').val();
            var universidad = $('#universidad').val();
            var titulo = $('#titulo').val();
            var fecha_terminacion = $('#fecha_terminacion').val();
            var fecha_grado = $('#fecha_grado').val();
//        var observaciones =$('#observaciones').val();

            if (modalidad == "-1" || universidad == '-1' || titulo == '-1' || fecha_terminacion == "") {
                $.notific8('Datos Incompletos', {
                    horizontalEdge: 'bottom',
                    theme: 'ruby',
                    heading: 'ERROR',
                    sticky: false
                });
                return false;
            }

            var chek = $('#graduado').is(':checked')
            if (chek == false) {
                if (sem == "0") {
                    $.notific8('Datos Semestre Incompleto', {
                        horizontalEdge: 'bottom',
                        theme: 'ruby',
                        heading: 'ERROR',
                        sticky: false
                    });
                    return false;
                }
            } else {
                if (fecha_grado == "") {
                    $.notific8('Datos Fecha Grado Incompleto', {
                        horizontalEdge: 'bottom',
                        theme: 'ruby',
                        heading: 'ERROR',
                        sticky: false
                    });
                    return false;
                }
            }

            var r = confirm('Desea Guardar Todos Los datos')
            if (r == true) {
                var url = '<?php echo base_url('index.php'); ?>/evaluacion/guardar_universidad';
//                Metronic.blockUI({
//                    target: '.modal-dialog',
//                    message: 'Cargando...'
//                });
                $.post(url, $('#form1').serialize())
                        .done(function(msg) {
                            UINotific8.init();
                            $.notific8('Los Datos en Formacion Fueron Guardados.', {
                                horizontalEdge: 'bottom',
                                life: 5000,
                                theme: 'amethyst',
                                heading: 'EXITO'
                            });
                            var datos = JSON.parse(msg);
                            Metronic.unblockUI('.modal-dialog');
                            $('#formulario_1_1').html('');
                            $('#formulario_1_1').html(datos.dato1);
                            $('#formulario_3_1').html('');
                            $('#formulario_3_1').html(datos.dato2);
                            $('#opcion').modal('hide');
                        }).fail(function() {
                    $.notific8('Error al Guardar', {
                        horizontalEdge: 'bottom',
                        theme: 'ruby',
                        heading: 'ERROR',
                        sticky: false
                    });
                    Metronic.unblockUI('.modal-dialog');
                });
            }
            console.log(i);
            i++;
        }
    })

    if ($('#fecha_grado').val() != "" || ($('#graduado').is(':checked')) == true) {
        $('#fecha_grado').show();
    }
</script>