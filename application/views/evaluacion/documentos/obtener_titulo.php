
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
                $archivo = str_replace('~/', 'http://172.16.210.37/rmdps/', $documentos2->RUTAADJUNTO_CRA);
                echo "<tr>"
                . "<td>" . $documentos2->CONSECUTIVO_CRA . "</td>"
                . "<td>" . $documentos2->MODALIDAD_MOD . '</td>'
                . "<td>" . $documentos2->UNIVERSIDAD_UNIV . '</td>'
                . "<td>" . $documentos2->TITULO_TIT . '</td>'
                . '<td>' . (($documentos2->REQUISITOMINIMO == 1) ? 'SI' : 'NO') . '</td>'
                . '<td><a target="_blank" href="' . $archivo . '">Ver Folio..</a></td>'
                . '</tr>';
            }
            ?>
        </table>
    </div>
    <div class="col-md-2 col-sm-2"></div>
</div>

<div class="col-md-12 col-sm-12">
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-md-8 col-sm-8">
        <div>SI<?php echo form_radio('requisitos_minimo', "1", false, 'class="requisitos_minimo"') ?></div>
        <div>NO<?php echo form_radio('requisitos_minimo', "0", false, 'class="requisitos_minimo"') ?></div>
        <br>
        Observación:<br>
        <textarea id="tex_requisitos_minimo" name="tex_requisitos_minimo" style="width: 100%"></textarea>
    </div>
    <div class="col-md-2 col-sm-2"></div>
</div>

<div class="col-md-12 col-sm-12">
    <h2 class="titulo3">EDUCACIÓN PARA EL TRABAJO Y EL DESARROLLO HUMANO </h2>
</div>