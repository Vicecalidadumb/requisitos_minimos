<?php 
print_y($modalidad);
?>
<div class="row">
    <div class="col-md-12 col-sm-12" >
        <table class="table table-bordered table-striped">
            <tr>
                <td>
                    Modalidad
                </td>
                <td>
                    <?php echo form_dropdown($data = "modalidad",$modalidad , '', $extra = 'class="form-control input-sm "') ?>
                    <?php echo form_dropdown($data = "Sem", array("s" => "sem"), '', $extra = 'class="form-control input-sm "') ?>
                </td>
            </tr>
            <tr>
                <td>
                    Graduado 
                    &nbsp;&nbsp;&nbsp;
                    <?php echo form_checkbox("graduado", "1", false) ?>
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
                    <?php echo form_dropdown($data = "universidad", array("-1" => ""), '', $extra = 'class="form-control input-sm "') ?>
                </td>
            </tr>
            <tr>
                <td>
                    Título
                </td>
                <td>
                    <?php echo form_dropdown($data = "titulo", array("-1" => ""), '', $extra = 'class="form-control input-sm "') ?>
                </td>
            </tr>
            <tr>
                <td>
                    Fecha Terminación 	
                </td>
                <td>
                    <?php echo form_input("fecha_terminacion",'' , $extra = 'class="form-control input-sm date-picker"') ?>
                </td>
            </tr>
            <tr>
                <td>
                    Fecha Grado
                </td>
                <td>
                    <?php echo form_input('fecha_grado', '', $extra = 'class="form-control input-sm date-picker"') ?>
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