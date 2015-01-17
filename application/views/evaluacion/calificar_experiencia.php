<?php
//echo print_y($experiencia);
?>

<form method="post" id="form2" >
    <input type="hidden" value="<?php echo $post['id'] ?>" id="id" name="id">
    <input type="hidden" value="<?php echo $post['idcal'] ?>" id="idcal" name="idcal">

    <div class="row">
        <div class="col-md-12 col-sm-12" >
            <table id="form2" class="table table-bordered table-striped">
                <tr>
                    <td>
                        <span class="label label-success">
                            La experiencia es Requisito Mínimo
                        </span>
                    </td>
                    <td>
                        <?php echo form_checkbox("REQUISITOMINIMO", '1', ($experiencia[0]->REQUISITOMINIMO) ? true : false, 'id="REQUISITOMINIMO"') ?>
                        </div>                        
                    </td>
                </tr>                
                <tr>
                    <td>
                        No. Folio
                    </td>
                    <td>
                        <?php echo $experiencia[0]->CONSECUTIVO_CRA ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Tipo de Experiencia
                    </td>
                    <td>
                        <?php echo $experiencia[0]->DETALLEPARAMETRO_PAR ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Entidad
                    </td>
                    <td>
                        <?php echo form_input("ENTIDAD_EL", $experiencia[0]->ENTIDAD_EL, $extra = 'class="form-control input-sm" id="ENTIDAD_EL"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Empleo y/o contratista Actual
                    </td>
                    <td>
                        <?php echo form_input("CARGO_EL", $experiencia[0]->CARGO_EL, $extra = 'class="form-control input-sm" id="CARGO_EL"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha Inicio
                    </td>
                    <td>
                        <?php echo form_input("FECHAINICIAL", date("Y-m-d", strtotime($experiencia[0]->FECHAINICIAL)), $extra = 'id="FECHAINICIAL" class="form-control input-sm fecha"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha Terminación
                    </td>
                    <td>
                        <?php echo form_input("FECHAFINAL", date("Y-m-d", strtotime($experiencia[0]->FECHAFINAL)), $extra = 'id="FECHAFINAL" class="form-control input-sm fecha"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Empleo y/o contratista Actual
                    </td>
                    <td>
                        <?php echo form_checkbox("EMPACTUAL_EL", '1', ($experiencia[0]->EMPACTUAL_EL) ? true : false, 'id="EMPACTUAL_EL"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Observaciones
                    </td>
                    <td>
                        <?php echo form_textarea('OBSERVACION', $experiencia[0]->OBSERVACION, $extra = 'id="OBSERVACION" style="width: 100%; height: 75px;" class="form-control input-sm "') ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="button" class="btn btn-success" id="guardar_exp">Guardar</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>
<script>
    $('#guardar_exp').click(function() {
        Metronic.blockUI({
            target: '.modal-dialog',
        });
        var ENTIDAD_EL = $('#ENTIDAD_EL').val();
        var CARGO_EL = $('#CARGO_EL').val();
        var FECHAINICIAL = $('#FECHAINICIAL').val();
        var OBSERVACION = $('#OBSERVACION').val();
        if (ENTIDAD_EL == "" || CARGO_EL == '' || FECHAINICIAL == '' || OBSERVACION == "") {
            Metronic.unblockUI('.modal-dialog');
            alert('Datos Incompletos');
            return false;
        }
        var r = confirm('Desea Guardar Todos Los datos');
        if (r == true) {
            var url = base_url_js + 'index.php/evaluacion/guardar_experiencia';
            $.post(url, $('#form2').serialize())
                    .done(function(msg) {
                        Metronic.unblockUI('.modal-dialog');
                        if (msg == 1) {
                            alert("Datos Guardados con exito");
                            $('#opcion').modal("hide");
                        } else
                            alert("Error al guardar");
                    }).fail(function() {
                alert('Error al Guardar');
            });
        } else {
            Metronic.unblockUI('.modal-dialog');
        }
    })
    $(".fecha").datepicker({
        format: 'yyyy-mm-dd',
        rtl: Metronic.isRTL(),
        orientation: "left",
        autoclose: true,
    });
</script>