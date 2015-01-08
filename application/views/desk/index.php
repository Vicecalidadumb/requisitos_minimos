<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            Escritorio
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo base_url('index.php/desk') ?>">
                        Escritorio
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

        <div class="row">
            <!--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            1349
                        </div>
                        <div class="desc">
                            Aspirantes Inscritos
                        </div>
                    </div>
                    <a class="more" href="<?php echo base_url(); ?>">
                        Ver m&aacute;s <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual">
                        <i class="fa fa-mortar-board"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            150
                        </div>
                        <div class="desc">
                            Aspirantes Perfilados
                        </div>
                    </div>
                    <a class="more" href="<?php echo base_url(); ?>">
                        Ver m&aacute;s <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            33
                        </div>
                        <div class="desc">
                            Ofertas de Empleo
                        </div>
                    </div>
                    <a class="more" href="<?php echo base_url(); ?>">
                        Ver m&aacute;s <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual">
                        <i class="fa fa-file-pdf-o"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            8654
                        </div>
                        <div class="desc">
                            Documentos Cargados
                        </div>
                    </div>
                    <a class="more" href="<?php echo base_url(); ?>">
                        Ver m&aacute;s <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>-->
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual">
                        <i class="fa fa-child"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <?php echo get_select(); ?>
                        </div>
                        <div class="desc">
                            Ver Aspirantes preseleccionados
                        </div>
                    </div>
                    <a class="more" href="<?php echo base_url('index.php/profile'); ?>">
                        Ver m&aacute;s <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>
            
        </div>   

        <!--        <div class="row ">
                    <div class="col-md-12 col-sm-12">
                         BEGIN PORTLET
                        <div class="portlet box blue-madison calendar">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-calendar"></i>Datos Estadisticos
                                </div>
                            </div>
                            <div class="portlet-body light-grey">
                            </div>
                        </div>
                         END PORTLET
                    </div>
                </div>-->

    </div>
</div>
<!-- END CONTENT -->