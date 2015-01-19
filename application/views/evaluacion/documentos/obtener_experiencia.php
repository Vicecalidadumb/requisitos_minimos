<div class="col-md-12 col-sm-12">
    <h2 class="titulo3">Cumple Requisitos Minimos de Experiencia</h2>
</div>

<div class="col-md-12 col-sm-12">
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-md-8 col-sm-8">
        <table class="table table-bordered table-striped">
            <thead>
            <th>N. Folio</th>
            <th>Tipo Experiencia</th>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th>RM</th>
            <th>Folio</th>
            </thead>
            <?php
            $i = 0;
            foreach ($experiencia as $documentos2) {
                if ($documentos2->REQUISITOMINIMO == 1) {
                    ?>
                    <tr>
                        <td><?php echo $documentos2->CONSECUTIVO_CRA; ?></td>
                        <td><?php echo $documentos2->DETALLEPARAMETRO_PAR; ?></td>

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
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
    <div class="col-md-2 col-sm-2"></div>
</div>

<div class="col-md-12 col-sm-12">
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-md-2 col-sm-2">
        SI&nbsp;&nbsp;<?php echo form_radio('requisitos_experiencia', "1", false, 'class="requisitos_experiencia "') ?>
    </div>
    <div class="col-md-2 col-sm-2">
        NO&nbsp;&nbsp;<?php echo form_radio('requisitos_experiencia', "0", false, 'class="requisitos_experiencia "') ?>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="col-md-2 col-sm-2"></div>
    <div class="col-md-8 col-sm-8">
        Observación:<br>
        <textarea id="tex_requisitos_minimo" class="form-control input-sm " name="tex_requisitos_minimo" style="width: 100%"></textarea>
    </div>
    <div class="col-md-2 col-sm-2"></div>
</div>