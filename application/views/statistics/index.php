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
                        Perfilamiento
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
                            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Documento</th>
                                        <th>Pin</th>
                                        <th>Fecha de Ingreso</th>
                                        <th>Ofertas</th>
                                        <th>Evaluado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    /*$contador = 1;
                                    foreach ($registros as $registro) {
                                        ?>
                                        <tr>
                                            <td>#</td>
                                            <td><?php echo $registro->USUARIO_NOMBRES; ?></td>
                                            <td>Apellidos</td>
                                            <td>Documento</td>
                                            <td>Pin</td>
                                            <td>Fecha de Ingreso</td>
                                            <td>Evaluado</td>
                                        </tr>
                                        <?php
                                        $contador++;
                                    }*/
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
