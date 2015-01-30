<div class="col-md-12 col-sm-12">
    <h2 class="titulo3">EXPERIENCIA</h2>
</div>

<div class="col-md-12 col-sm-12">
    <table class="table table-bordered table-striped">
        <thead>
        <th>N. Folio</th>
        <th>Tipo Experiencia</th>
        <th>Entidad</th>
        <th>Cargo</th>
        <th>Fecha Inicial</th>
        <th>Fecha Final</th>
        <th>RM</th>
        <th>Folio</th>
        <th>Modificar</th>
        </thead>
        <?php
        $i = 0;
        foreach ($experiencia as $documentos2) {
            ?>
            <tr>
                <td><?php echo $documentos2->CONSECUTIVO_CRA; ?></td>
                <td><?php echo $documentos2->DETALLEPARAMETRO_PAR; ?></td>
                <td><?php echo $documentos2->ENTIDAD_EL; ?></td>
                <td><?php echo $documentos2->CARGO_EL; ?></td>
                <td>
                    <?php
                    $date = new DateTime($documentos2->FECHAINICIAL);
                    echo $date->format('M d Y');
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($documentos2->FECHAFINAL)) {
                        $date = new DateTime($documentos2->FECHAFINAL);
                        echo $date->format('M d Y');
                    }
                    ?>
                </td>                
                <td><?php echo (($documentos2->REQUISITOMINIMO == 1) ? 'SI' : 'NO'); ?></td>
                <td>
                    <?php
                    if (!empty($documentos2->RUTAADJUNTO_CRA)) {
                        $url = str_replace('~/', 'http://convocatoriadps.umb.edu.co/dps_rm/', $documentos2->RUTAADJUNTO_CRA);
                        ?>
                        <a target="_blank" href="<?php echo (!empty($documentos2->RUTAADJUNTO_CRA)) ? $url : ''; ?>">Ver Folio..</a>
                        <?php
                    } else
                        echo 'Ver Folio..';
                    ?>
                </td>
                <td align="center">
                    <button type="button" class="btn defaul btn-xs opcion"  
                            data-toggle="modal" 
                            data-target="#opcion"
                            data-accion="editar_exp"
                            data-id_glo="<?php echo $get['id']; ?>"
                            data-id="<?php echo $documentos2->CONSECUTIVO_CRA; ?>"
                            data-idcal="<?php echo $documentos2->IDCALIFICACION_RM_AA_CRA; ?>">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </button>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<div class="col-md-12 col-sm-12" style="text-align: center">
    <button type="button" class="btn defaul green opcion"
            data-toggle="modal" 
            data-target="#opcion"
            data-accion="editar_exp"
            data-id_glo="<?php echo $get['id']; ?>"
            data-id=""
            data-idcal="">
        Nuevo Folio
    </button>
</div>
