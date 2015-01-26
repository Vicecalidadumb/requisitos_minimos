<?php
//echo print_y($experiencia);
?>
<form method="post" id="form2" >
    <input type="hidden" value="<?php echo (isset($post['id']) && $post['id'] != '') ? $post['id'] : ''; ?>" id="id" name="id">
    <input type="hidden" value="<?php echo (isset($post['idcal']) && $post['idcal'] != '') ? $post['idcal'] : ''; ?>" id="idcal" name="idcal">
    <input type="hidden" value="<?php echo $post['id_glo']; ?>" id="id_glo" name="id_glo">

    <div class="row">
        <div class="col-md-12 col-sm-12" >
            <table id="form2" class="table table-bordered table-striped">
                <tr>
                    <td>
                        La experiencia es Requisito Mínimo
                    </td>
                    <td>
                        <?php echo form_checkbox("REQUISITOMINIMO", '1', (isset($experiencia[0]->REQUISITOMINIMO)) ? true : false, 'id="REQUISITOMINIMO"') ?>
                        </div>                        
                    </td>
                </tr> 
                <?php if (isset($post['id']) && $post['id'] != '') { ?>
                    <tr>
                        <td>
                            No. Folio
                        </td>
                        <td>
                            <?php echo $experiencia[0]->CONSECUTIVO_CRA ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>
                        Tipo de Experiencia
                    </td>
                    <td>
                        <?php
                        if (isset($post['id']) && $post['id'] != '')
                            echo $experiencia[0]->DETALLEPARAMETRO_PAR;
                        else
                            echo form_dropdown('IDTIPOADJUNTO_CRA', $tipoexperiencia, '', 'form-control');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Entidad
                    </td>
                    <td>
                        <?php echo form_input("ENTIDAD_EL", (isset($experiencia[0]->ENTIDAD_EL)) ? $experiencia[0]->ENTIDAD_EL : '', $extra = 'class="form-control input-sm" id="ENTIDAD_EL"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Empleo y/o contratista Actual
                    </td>
                    <td>
                        <?php echo form_input("CARGO_EL", (isset($experiencia[0]->CARGO_EL)) ? $experiencia[0]->CARGO_EL : '', $extra = 'class="form-control input-sm" id="CARGO_EL"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha Inicio
                    </td>
                    <td>
                        <?php echo form_input("FECHAINICIAL", (isset($experiencia[0]->FECHAINICIAL)) ? date("Y-m-d", strtotime($experiencia[0]->FECHAINICIAL)) : '', $extra = 'id="FECHAINICIAL" class="form-control input-sm fecha"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fecha Terminación
                    </td>
                    <td>
                        <?php echo form_input("FECHAFINAL", (isset($experiencia[0]->FECHAFINAL)) ? date("Y-m-d", strtotime($experiencia[0]->FECHAFINAL)) : '', $extra = 'id="FECHAFINAL" class="form-control input-sm fecha"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Empleo y/o contratista Actual
                    </td>
                    <td>
                        <?php echo form_checkbox("EMPACTUAL_EL", '1', (isset($experiencia[0]->EMPACTUAL_EL)) ? true : false, 'id="EMPACTUAL_EL"') ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Observaciones
                    </td>
                    <td>
                        <?php echo form_textarea('OBSERVACION', (isset($experiencia[0]->OBSERVACION)) ? $experiencia[0]->OBSERVACION : '', $extra = 'id="OBSERVACION" style="width: 100%; height: 75px;" class="form-control input-sm "') ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php if ($userdata['ID_TIPO_USU'] == 6) { ?>
                            <button type="button" class="btn btn-success" id="guardar_exp">Guardar</button>
                        <?php } ?>
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
            message: 'Cargando...'
        });
        var ENTIDAD_EL = $('#ENTIDAD_EL').val();
        var CARGO_EL = $('#CARGO_EL').val();
        var FECHAINICIAL = $('#FECHAINICIAL').val();
        var OBSERVACION = $('#OBSERVACION').val();
        if (ENTIDAD_EL == "" || CARGO_EL == '' || FECHAINICIAL == '' || OBSERVACION == "") {
            Metronic.unblockUI('.modal-dialog');
            $.notific8('Datos Incompletos', {
                horizontalEdge: 'bottom',
                theme: 'ruby',
                heading: 'ERROR',
                sticky: false
            });
            return false;
        }
        var r = confirm('Desea Guardar Todos Los datos');
        if (r == true) {
            var url = base_url_js + 'index.php/evaluacion/guardar_experiencia';
            $.post(url, $('#form2').serialize())
                    .done(function(msg) {
                        Metronic.unblockUI('.modal-dialog');
                        var datos = JSON.parse(msg);
                        if (datos.result == 1) {
                            $('#formulario_2').html(datos.doc_experiencia);
                            $('#formulario_3_2').html(datos.obtener_experiencia);
                            $('#opcion').modal("hide");
                            UINotific8.init();
                            $.notific8('Los Datos en Experiencia Fueron Guardados.', {
                                horizontalEdge: 'bottom',
                                life: 5000,
                                theme: 'amethyst',
                                heading: 'EXITO'
                            });
                        } else {
                            $.notific8('Error al guardar', {
                                horizontalEdge: 'bottom',
                                theme: 'ruby',
                                heading: 'ERROR',
                                sticky: true
                            });
                        }
                    }).fail(function() {
                $.notific8('Error al guardar', {
                    horizontalEdge: 'bottom',
                    theme: 'ruby',
                    heading: 'ERROR',
                    sticky: true
                });
                Metronic.unblockUI('.modal-dialog');
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