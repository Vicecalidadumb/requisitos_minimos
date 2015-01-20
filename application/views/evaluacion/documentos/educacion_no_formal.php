<div class="col-md-12 col-sm-12">
    <h2 class="titulo3">EDUCACIÓN PARA EL TRABAJO Y EL DESARROLLO HUMANO </h2>
</div>

<div class="col-md-12 col-sm-12">
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-md-8 col-sm-8">

        <table class="table table-bordered table-striped">
            <thead>
            <th>N. Folio</th>
            <th>Institución</th>
            <th>Título/ Nombre de Curso</th>
            <th>Horas</th>
            <th>Fecha</th>
            <th>Folio</th>
            </thead>
            <?php
            $i = 0;
            foreach ($educacion_no_formal as $documentos2) {
                $archivo = str_replace('~/', 'http://172.16.210.37/rmdps/', $documentos2->RUTAADJUNTO_CRA);
                if (!empty($documentos2->RUTAADJUNTO_CRA))
                    $archivo = '<td><a target="_blank" href="' . $archivo . '">Ver Folio..</a></td>';
                else
                    $archivo = "<td>Ver Folio..</td>";
                echo "<tr>"
                . "<td>" . $documentos2->CONSECUTIVO_CRA . "</td>"
                . "<td>" . $documentos2->INSTITUCION_EDNF . '</td>'
                . "<td>" . $documentos2->TITULO_EDNF . '</td>'
                . "<td>" . $documentos2->HORAS_EDNF . '</td>'
                . "<td>" . date('Y-m-d',strtotime($documentos2->FECHA_EDNF)). '</td>'
                . $archivo
                . '</tr>';
            }
            ?>
        </table>
    </div>
    <div class="col-md-2 col-sm-2"></div>
</div>
