<?php
//echo print_y($experiencia);
?>

<form method="post" id="form1" >
    <input type="hidden" value="<?php echo $post['id'] ?>" id="id" name="id">
    <input type="hidden" value="<?php echo $post['idcal'] ?>" id="id" name="idcal">

    <div class="row">
        <div class="col-md-12 col-sm-12" >
            <table class="table table-bordered table-striped">
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
                        <?php echo form_input("FECHAINICIAL", date("Y-m-d", strtotime($experiencia[0]->FECHAINICIAL)), $extra = 'class="form-control input-sm fecha"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha Terminación
                    </td>
                    <td>
                        <?php echo form_input("FECHAFINAL", date("Y-m-d", strtotime($experiencia[0]->FECHAFINAL)), $extra = 'class="form-control input-sm fecha"') ?>
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
                        <?php echo form_textarea('OBSERVACION', $experiencia[0]->OBSERVACION, $extra = 'style="width: 100%; height: 75px;" class="form-control input-sm "') ?>
                    </td>
                </tr>               
            </table>
        </div>
    </div>
</form>
<script>
    $('#guardar').click(function() {

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
                    .done(function(msg) {
                        alert(msg);
                    }).fail(function() {

            });
        }
    })
</script>