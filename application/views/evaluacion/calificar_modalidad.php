<form method="post" id="form1" >
    <input type="hidden" value="<?php echo $post['id'] ?>" id="id" name="id">
    <input type="hidden" value="<?php echo $post['idcal'] ?>" id="id" name="idcal">

    <div class="row">
        <div class="col-md-12 col-sm-12" >
            <table class="table table-bordered table-striped">
                <tr>
                    <td>
                        Modalidad
                    </td>
                    <td>
                        <?php echo form_dropdown($data = "modalidad", $modalidad, '', $extra = 'class="form-control input-sm " id="modalidad"') ?>
                        <?php echo form_dropdown($data = "sem", array("0" => "sem", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12"), '', $extra = 'class="form-control input-sm " id="sem"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Graduado 
                        &nbsp;&nbsp;&nbsp;
                        <?php echo form_checkbox("graduado", "1", false, "id='graduado' onclick='activar();'") ?>
                    </td>
                    <td>
                        Obtenido en el Extranjero 
                        &nbsp;&nbsp;&nbsp;
                        <?php echo form_checkbox("graduado_ext", "1", false) ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Universidad o Institución
                    </td>
                    <td>
                        <?php echo form_dropdown($data = "universidad", array("-1" => ""), '', $extra = 'id="universidad" class="form-control input-sm "') ?>
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
                        <?php echo form_dropdown($data = "titulo", array("-1" => ""), '', $extra = 'class="form-control input-sm" id="titulo"') ?>
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
                        <?php echo form_input("fecha_terminacion", '', $extra = 'class="form-control input-sm fecha"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha Grado
                    </td>
                    <td>
                        <?php echo form_input('fecha_grado', '', $extra = 'class="form-control input-sm fecha" id="fecha_grado"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Observaciones
                    </td>
                    <td>
                        <?php echo form_textarea('observaciones', $value = "", $extra = 'style="width: 100%; height: 75px;" class="form-control input-sm "') ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>
<script>
    $('#guardar_uni').click(function () {
        var universidad_otra = $('#universidad_otra').val()
        if (universidad_otra == "") {
            alert('Dato de Universidad Incompleto');
            return false;
        }
        var modalidad = $('#modalidad').val()
        var universidad = $('#modalidad').val()
        var url = '<?php echo base_url('index.php'); ?>/evaluacion/nueva_universidad';
        $.post(url, {universidad_otra: universidad_otra, modalidad: modalidad, universidad: universidad})
                .done(function (msg) {
                    $('#universidad').html(msg);
                    $('#universidad_otra').val('');
                    alert('Los datos fueron Guardados con Exito')
                    $('#universidad_otra2').hide();
                }).fail(function (msg) {
            alert('Error en la Base de Datos');
        })

        return false;
    });
    $('#guardar_titulo').click(function () {
        var titulo_otra = $('#titulo_otra').val()
        if (titulo_otra == "") {
            alert('Dato de Titulo Incompleto');
            return false;
        }
        var universidad = $('#universidad').val();
        var titulo = $('#universidad').val();
        var url = '<?php echo base_url('index.php'); ?>/evaluacion/nuevo_titulo';
        $.post(url, {titulo_otra: titulo_otra, universidad: universidad,titulo:titulo})
                .done(function (msg) {
                    $('#titulo').html(msg);
                    $('#titulo_otra').val('');
                    alert('Los datos fueron Guardados con Exito')
                    $('#titulo_otra2').hide();
                }).fail(function (msg) {
            alert('Error en la Base de Datos');
        })

        return false;
    });
    $('#titulo').change(function () {
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
    $('#modalidad').change(function () {
        var universidad = $(this).val();
        if (universidad == -1)
            return false;
        var url = '<?php echo base_url('index.php'); ?>/evaluacion/universidad';
        $.post(url, {universidad: universidad})
                .done(function (msg) {
                    $('#universidad').html(msg);
                }).fail(function (msg) {
            alert('Error en la Base de Datos');
        });
    });
    $('#universidad').change(function () {
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
        $.post(url, {titulo: titulo})
                .done(function (msg) {
                    $('#titulo').html(msg);
                }).fail(function (msg) {
            alert('Error en la Base de Datos');
        });
    });
    $('#guardar').click(function () {
        
        var titulo = $('#titulo option:selected').text();
        if (titulo == 'OTRO') {
            alert('Valor del Titulo no es Correcto');
            return false
        }
        var titulo = $('#universidad option:selected').text();
        if (titulo == 'OTRA') {
            alert('Valor del Titulo no es Correcto');
            return false
        }
        
        var modalidad = $('#modalidad').val();
        var sem = $('#sem').val();
        var universidad = $('#universidad').val();
        var titulo = $('#titulo').val();
        var fecha_terminacion = $('#fecha_terminacion').val();
        var fecha_grado = $('#fecha_terminacion').val();
//        var observaciones =$('#observaciones').val();

        if (modalidad == "-1" || universidad == '-1' || titulo == '-1' || fecha_terminacion == "") {
            alert('Datos Incompletos');
            return false;
        }

        var chek = $('#graduado').is(':checked')
        if (chek == false) {
            if (sem == "0") {
                alert('Datos Semestre Incompleto');
                return false;
            }
        } else {
            if (fecha_grado == "") {
                alert('Datos Fecha Grado Incompleto');
                return false;
            }
        }

        var r = confirm('Desea Guardar Todos Los datos')
        if (r == true) {
            var url = '<?php echo base_url('index.php'); ?>/evaluacion/guardar_universidad';
            $.post(url, $('#form1').serialize())
                    .done(function (msg) {
                        alert(msg);
                    }).fail(function () {

            });
        }
    })
</script>