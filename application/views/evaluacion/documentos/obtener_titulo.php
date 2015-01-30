<div id="formulario_3_1">
    <div class="col-md-12 col-sm-12">
        <h2 class="titulo3">Cumple Requisitos Minimos de Estudio </h2>
    </div>

    <div class="col-md-12 col-sm-12">
        <div class="col-md-2 col-sm-2"></div>
        <div class="col-md-8 col-sm-8">

            <table class="table table-bordered table-striped">
                <thead>
                <th>N. Folio</th>
                <th>Modalidad</th>
                <th>Universidad/Instituto</th>
                <th>Titulo/Nombre programa</th>
                <th>RM</th>
                <th>Folio</th>
                </thead>
                <?php
                $i = 0;
                foreach ($obtener_titulo as $documentos2) {
                    $archivo = str_replace('~/', 'http://convocatoriadps.umb.edu.co/dps_rm/', $documentos2->RUTAADJUNTO_CRA);
                    if (!empty($documentos2->RUTAADJUNTO_CRA))
                        $archivo = '<td><a target="_blank" href="' . $archivo . '">Ver Folio..</a></td>';
                    else
                        $archivo = "<td>Ver Folio..</td>";
                    echo "<tr>"
                    . "<td>" . $documentos2->CONSECUTIVO_CRA . "</td>"
                    . "<td>" . $documentos2->MODALIDAD_MOD . '</td>'
                    . "<td>" . $documentos2->UNIVERSIDAD_UNIV . '</td>'
                    . "<td>" . $documentos2->TITULO_TIT . '</td>'
                    . '<td>' . (($documentos2->REQUISITOMINIMO == 1) ? 'SI' : 'NO') . '</td>'
                    .  $archivo
                    . '</tr>';
                }
                ?>
            </table>
        </div>
        <div class="col-md-2 col-sm-2"></div>
    </div>
</div>