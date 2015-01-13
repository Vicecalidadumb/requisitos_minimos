<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
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
                </td>
            </tr>
            <tr>
                <td>
                    Título
                </td>
                <td>
                    <?php echo form_dropdown($data = "titulo", array("-1" => ""), '', $extra = 'class="form-control input-sm" id="titulo"') ?>
                </td>
            </tr>
            <tr>
                <td>
                    Fecha Terminación 	
                </td>
                <td>
                    <?php echo form_input("fecha_terminacion", '', $extra = 'class="form-control input-sm date-picker"') ?>
                </td>
            </tr>
            <tr>
                <td>
                    Fecha Grado
                </td>
                <td>
                    <?php echo form_input('fecha_grado', '', $extra = 'class="form-control input-sm fecha"') ?>
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
<script>
    $(".fecha").datepicker();

    function activar() {
        var chek = $('#graduado').is(':checked')
        if (chek == true)
            $('#sem').hide();
        else
            $('#sem').show();
    }
    $('#modalidad').change(function () {
        var universidad = $(this).val();
        if (universidad == 0)
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
        var titulo = $(this).val();
        if (titulo == 0)
            return false;
        var url = '<?php echo base_url('index.php'); ?>/evaluacion/titulo';
        $.post(url, {titulo: titulo})
                .done(function (msg) {
                    $('#titulo').html(msg);
                }).fail(function (msg) {
            alert('Error en la Base de Datos');
        });
    });
</script>