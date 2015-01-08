<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            Listado de <small>Empleos</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo base_url('index.php/desk') ?>">
                        Escritorio
                    </a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?php echo base_url('index.php/statistics') ?>">
                        Reportes
                    </a>
                </li>                    
            </ul>           
        </div>
        <!-- END PAGE HEADER-->

        <div class="clearfix">
        </div>

        <?php
        echo count($empleos) . '<br>';
        echo count($documents);
        //echo '<pre>'.print_r($documents,true).'</pre>';
        ?>


        <div class="col-md-12 col-sm-12">
            <?php if ($this->session->flashdata('message')) { ?>
                <div class="alert alert-<?php echo $this->session->flashdata('message_type'); ?>">
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php } ?>          
        </div>        

        <div class="row ">
            <div class="col-md-12 col-sm-12">
                <!-- BEGIN SAMPLE TABLE PORTLET-->
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Listado de Aspirantes
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">

                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>EMPLEO</th>
                                        <th>PIN</th>
                                        <th>REGION_EMPLEO</th>
                                        <th>CIUDAD_RESIDENCIA</th>
                                        <th>DOCUMENTOS</th>
                                        <th>ASIGNADO</th>
                                        <th>EVALUACION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 1;
                                    foreach ($empleos as $registro) {
                                        ?>
                                        <tr>
                                            <td><?php echo $contador; ?></td>
                                            <td><?php echo $registro->EMPLEO_ID; ?></td>
                                            <td><?php echo $registro->INSCRIPCION_PIN; ?></td>
                                            <td><?php echo $registro->REGIONAL_NOMBRE; ?></td>
                                            <td><?php echo $registro->MUNICIPIO_NOMBRE; ?></td>
                                            <td>
                                                <?php
                                                $documento_ok = '__';
                                                foreach ($documents as $document) {
                                                    if ($document->INSCRIPCION_PIN == $registro->INSCRIPCION_PIN) {
                                                        $documento_ok = 'SI';
                                                    }
                                                }
                                                echo $documento_ok;
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                $asignado_ok = '__';
                                                foreach ($assignments as $assignment) {
                                                    if ($assignment->INSCRIPCION_PIN == $registro->INSCRIPCION_PIN) {
                                                        $asignado_ok = $assignment->USUARIO_NOMBRES;
                                                    }
                                                }
                                                echo $asignado_ok;
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                $eva = 0;
                                                $eva_1 = 0;
                                                $eva_2 = 0;
                                                $eva_4 = 0;
                                                foreach ($assessments as $assessment) {
                                                    if ($assessment->INSCRIPCION_PIN == $registro->INSCRIPCION_PIN) {
                                                        $eva = 1;
                                                        if ($assessment->TIPOEVALUACION_ID == 1 && $assessment->EVALUACION_CUMPLE == 1) {
                                                            $eva_1 = 1;
                                                        }
                                                        if ($assessment->TIPOEVALUACION_ID == 2 && $assessment->EVALUACION_CUMPLE == 1) {
                                                            $eva_2 = 1;
                                                        }
                                                        if ($assessment->TIPOEVALUACION_ID == 4 && $assessment->EVALUACION_CUMPLE == 1) {
                                                            $eva_4 = 1;
                                                        }
                                                    }
                                                }
                                                if ($eva == 1) {
                                                    if (($eva_1 + $eva_2 + $eva_4) >= 3) {
                                                        echo "OK";
                                                    } else {
                                                        echo "NO";
                                                    }
                                                }else{
                                                    echo "__";
                                                }
                                                ?>
                                            </td>                                            
                                        </tr>
                                        <?php
                                        $contador++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
