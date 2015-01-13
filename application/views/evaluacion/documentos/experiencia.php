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
                    $date = new DateTime($documentos2->FECHAFINAL);
                    echo $date->format('M d Y');
                    ?>
                </td>                
                <td><?php echo (($documentos2->REQUISITOMINIMO == 1) ? 'SI' : 'NO'); ?></td>
                <td>
                    <a target="_blank" href="<?php echo str_replace('~/', 'http://172.16.210.37/rmdps/', $documentos2->RUTAADJUNTO_CRA); ?>">Ver Folio..</a>
                </td>
                <td align="center">
                    <button type="button" class="btn defaul btn-xs"  
                            data-toggle="modal" 
                            data-target="#opcion"
                            data-accion="editar_exp" 
                            data-id="<?php echo $documentos2->CONSECUTIVO_CRA; ?>">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </button>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

<div class="col-md-12 col-sm-12">
    <button>Nuevo Folio</button>
</div>
