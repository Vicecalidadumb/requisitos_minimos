<div class="col-md-12 col-sm-12">
    <h2 class="titulo3">DOCUMENTOS DE EDUCACIÓN</h2>
</div>

<div class="col-md-12 col-sm-12">
    <h2 class="tituloR">EDUCACIÓN FORMAL</h2>
</div>

<div class="col-md-12 col-sm-12">
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-md-8 col-sm-8">

        <table class="table table-bordered table-striped">
            <thead><th>N. Folio</th><th>Modalidad</th><th>Requisito Mínimo</th><th>Folio</th><th>Modificar</th></thead>
            <?php
            $i = 0;
            foreach ($educacion_formal as $documentos2) {
                $archivo = str_replace('~/', 'http://172.16.210.37/rmdps/', $documentos2->RUTAADJUNTO_CRA);
                if(!empty($documentos2->RUTAADJUNTO_CRA))
                $archivo='<td><a target="_blank" href="' . $archivo . '">Ver Folio..</a></td>';
                else
                    $archivo="<td>Ver Folio..</td>";
                echo "<tr>"
                . "<td>" . $documentos2->CONSECUTIVO_CRA . "</td>"
                . "<td>" . $documentos2->MODALIDAD_MOD . '</td>'
                . '<td>' . (($documentos2->REQUISITOMINIMO == 1) ? 'SI' : 'NO') . '</td>'
                . $archivo
                . '<td align="center"><button type="button" class="btn defaul btn-xs opcion"  data-toggle="modal" data-target="#opcion" data-accion="editar" data-tipoadj="'.$documentos2->IDTIPOADJUNTO_CRA.'" data-id_glo="' . $get['id'] . '" data-id="' . $documentos2->CONSECUTIVO_CRA . '" data-idcal="' . $documentos2->IDCALIFICACION_RM_AA_CRA . '" data-requisito="' . $documentos2->REQUISITOMINIMO . '"><i class="glyphicon glyphicon-pencil"></i></button></td>'
                . '</tr>';
                $tipo_adj=$documentos2->IDTIPOADJUNTO_CRA;
            }
            ?>
        </table>
    </div>
    <div class="col-md-2 col-sm-2"></div>
</div>

<div class="col-md-12 col-sm-12">
    <center><button type="button" class="btn green opcion"  data-toggle="modal" data-target="#opcion" data-accion="editar" data-id_glo="<?php echo  $get['id']?>" data-id="" data-tipoadj="<?php echo $tipo_adj; ?>" data-idcal="" data-requisito="">Nuevo Folio</button></center>
</div>

<div class="col-md-12 col-sm-12">
    <h2 class="titulo3">EDUCACIÓN PARA EL TRABAJO Y EL DESARROLLO HUMANO </h2>
</div>