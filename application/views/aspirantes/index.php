<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            Carpetas Asignadas
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a>
                        Listado de Aspirantes
                    </a>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="clearfix">
        </div>
        <!-- BEGIN FLASHDATA-->
        <div class="col-md-12 col-sm-12">
            <?php if ($this->session->flashdata('message')) { ?>
                <div class="alert alert-<?php echo $this->session->flashdata('message_type'); ?>">
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php } ?>
        </div>  
        <!-- END FLASHDATA-->   
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Carpetas Asignadas
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>                            
                        </div>
                    </div>
                    <div class="portlet-body" id="blockui_sample_3_2_element">
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th>Carpeta</th>
                                        <th>Estado</th>
                                        <th>Documento</th>
                                        <th>Pin</th>
                                        <th>Aspirante</th>
                                        <th>Estudio</th>
                                        <th>Experiencia</th>
                                        <th>Opciones</th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td rowspan="1" colspan="1">
                                            <input placeholder="Buscar por No. Carpeta" type="text" class="form-control form-filter input-sm" id="bSearchable2_0">
                                        </td>
                                        <td rowspan="1" colspan="1">
                                            <?php echo form_dropdown('bSearchable2_1', state_folder(), '', 'id="bSearchable2_1" class="form-control form-filter input-sm"') ?>
                                        </td>
                                        <td rowspan="1" colspan="1">
                                            <input placeholder="Buscar por No. Documento" type="text" class="form-control form-filter input-sm" id="bSearchable2_2">
                                        </td>
                                        <td rowspan="1" colspan="1">
                                            <input placeholder="Buscar por No. Pin" type="text" class="form-control form-filter input-sm" id="bSearchable2_3">
                                        </td>
                                        <td rowspan="1" colspan="1">
                                            <input placeholder="Buscar Solo por Nombre" type="text" class="form-control form-filter input-sm" id="bSearchable2_4">
                                        </td>
                                        <td rowspan="1" colspan="1"></td>
                                        <td rowspan="1" colspan="1"></td> 
                                        <td>
                                            <div class="margin-bottom-5">
                                                <button class="btn btn-sm yellow filter-submit margin-bottom reload"><i class="fa fa-search"></i> Buscar</button>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
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