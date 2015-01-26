<div class="col-md-12 col-sm-12">
    <h2 class="titulo3">DOCUMENTOS ESPECÍFICOS DE LA CONVOCATORIA </h2>
</div>

<div class="col-md-12 col-sm-12">
    <div class="col-md-2 col-sm-2">&nbsp;</div>
    <div class="col-md-8 col-sm-8">
        <table class="table table-bordered table-striped">
            <thead><th>N. Folio</th><th>Documento</th><th>Folio</th></thead>
            <?php
            $i = 0;
            foreach ($documentos as $documentos2) {
                $archivo = str_replace('~/', 'http://172.16.79.8/rmdps/', $documentos2->RUTAADJUNTO_DOC);
                if (!empty($documentos2->RUTAADJUNTO_DOC))
                    $archivo = '<td><a target="_blank" href="' . $archivo . '">Ver Folio..</a></td>';
                else
                    $archivo = "<td>Ver Folio..</td>";
                
                echo "<tr><td>" . $documentos2->FOLIO_DOC . "</td>"
                        . "<td>" . $documentos2->DETALLEPARAMETRO_PAR . '</td>'
                        .  $archivo
                        . '</tr>';
            }
            ?>
        </table>
    </div>
    <div class="col-md-2 col-sm-2">&nbsp;</div>
</div>