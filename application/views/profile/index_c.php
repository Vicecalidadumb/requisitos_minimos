<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            Listado de <small>Aspirantes</small>
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
                    <a href="<?php echo base_url('index.php/profile') ?>">
                        Aspirantes
                    </a>
                </li>                    
            </ul>           
        </div>
        <!-- END PAGE HEADER-->

        <div class="clearfix">
        </div>

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
                            <table class="table table-striped table-bordered table-hover" id="sample_111">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pin</th>
                                        <th>Empleo - Region</th>
                                        <th>Puesto</th>
                                        <th>Nombres</th>
                                        <th>Ciudad</th>
                                        <th>Documento</th>
                                        <th>Fecha de Ingreso</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 1;
                                    foreach ($registros as $registro) {
                                        ?>
                                        <tr>
                                            <td><?php echo $contador; ?></td>
                                            <td><?php echo $registro->INSCRIPCION_PIN; ?></td>
                                            <td><?php echo get_pin_select($registro->INSCRIPCION_PIN,1).' - '.get_reg_select($registro->INSCRIPCION_PIN,get_pin_select($registro->INSCRIPCION_PIN,0)); ?></td>
                                            <td><?php echo get_puesto_select($registro->INSCRIPCION_PIN,get_pin_select($registro->INSCRIPCION_PIN,0)); ?></td>
                                            <td><?php echo $registro->USUARIO_NOMBRES; ?></td>
                                            <td><?php echo $registro->USUARIO_APELLIDOS; ?></td>
                                            <td><?php echo $registro->USUARIO_TIPODOCUMENTO.' '.$registro->USUARIO_NUMERODOCUMENTO; ?></td>
                                            <td><?php echo $registro->USUARIO_FECHAINGRESO; ?></td>
                                            <td>
                                                <a target="_blank" href="<?php echo base_url('index.php/profile/assess/'.$registro->INSCRIPCION_PIN.'/'.$registro->ASIGNACION_ID) ?>" class="btn default btn-xs blue-stripe">
                                                    Ver Documentos
                                                </a>
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
