<div class="col-md-12 col-sm-12">
    <h2 class="titulo3">EXPERIENCIA</h2>
</div>

<div class="col-md-12 col-sm-12">
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-md-8 col-sm-8">
        <table class="table table-bordered table-striped">
            <thead><th>N. Folio</th><th>Documento</th><th>Folio</th><th>Modificar</th></thead>
            <?php
            $i = 0;
            foreach ($experiencia as $documentos2) {
                $archivo = str_replace('~/', 'http://172.16.210.37/rmdps/', $documentos2->RUTAADJUNTO_CRA);
                echo "<tr><td>" . $documentos2->CONSECUTIVO_CRA . "</td><td>" . $documentos2->MODALIDAD_MOD . '</td><td><a target="_blank" href="' . $archivo . '">Ver Folio..</a></td><td align="center"><button type="button" class="btn defaul btn-xs"  data-toggle="modal" data-target="#opcion" data-accion="editar" data-id="' . $documentos2->CONSECUTIVO_CRA . '"><i class="glyphicon glyphicon-pencil"></i></button></td></tr>';
            }
            ?>
        </table>
    </div>
    <div class="col-md-2 col-sm-2"></div>
</div>

<div class="col-md-12 col-sm-12">
    <button>Nuevo Folio</button>
</div>
