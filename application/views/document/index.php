<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            Documentos Corte
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo base_url('desk') ?>">
                        Escritorio
                    </a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <a href="<?php echo base_url('document') ?>">
                        Documentos Corte
                    </a>
                </li>                    
            </ul>
            <div class="page-toolbar">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
                        Acciones <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li>
                            <a href="<?php echo base_url('contract/add') ?>">
                                Agregar Documento a Corte
                            </a>
                        </li>
                    </ul>
                </div>
            </div>            
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
                            <i class="fa fa-cogs"></i>Listado de Contratos
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                         <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">
                                            Año
                                        </label>
                                        <div class="col-md-9">
                                            <?php echo form_dropdown('DOC_ANO', $states, '', 'onchange=""  id="HV_LUGARDENACIMIENTO_DTO" class="form-control"'); ?>
                                        </div>
                                    </div>
                        </div>  
                        
                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">
                                            Mes
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9" id='space_HV_LUGARDENACIMIENTO'>
                                            <?php echo form_dropdown('DOC_MES', array("" => "--SELECCIONE PRIMERO UN DEPARTAMENTO--"), '', 'id="HV_LUGARDENACIMIENTO" class="form-control"'); ?>
                                        </div>
                                    </div>
                       </div>
                        
                        <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">
                                            Corte
                                            <span class="required" aria-required="true">*</span>
                                        </label>
                                        <div class="col-md-9" id='space_HV_LUGARDENACIMIENTO'>
                                            <?php echo form_dropdown('HV_LUGARDENACIMIENTO', array("" => "--SELECCIONE PRIMERO UN DEPARTAMENTO--"), '', 'id="HV_LUGARDENACIMIENTO" class="form-control"'); ?>
                                        </div>
                                    </div>
                                </div>

                        <div class="table-scrollable">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Documento</th>
                                        <th>Profesion</th>  
                                        <th>Fecha de Inicio</th>
                                        <th>Fecha Final</th>
                                        <th>Contrato</th>
                                        <th>Proyecto</th>
                                        <th>Opciones</th>                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($registros as $registro) {
                                        ?>
                                        <tr <?php echo ($registro->HV_ESTADO == 0) ? 'class="danger"' : '' ?>>
                                            <td>
                                                <?php echo $count; ?>
                                            </td>
                                            <td>
                                                <?php echo $registro->HV_NOMBRES . ' ' . $registro->HV_APELLIDOS; ?>
                                            </td>
                                            <td>
                                                <?php echo $registro->HV_TIPODOCUMENTO . ' ' . $registro->HV_NUMERODOCUMENTO; ?>
                                            </td>
                                            <td>
                                                <?php echo $registro->HV_PROFESION; ?>
                                            </td>                                            
                                            <td>
                                                <?php echo $registro->CONTRATO_FECHAINI; ?>
                                            </td>
                                            <td>
                                                <?php echo $registro->CONTRATO_FECHAFIN; ?>
                                            </td>  
                                            <td>
                                                <?php echo $registro->TIPOCONTRATO_NOMBRE; ?>
                                            </td>  
                                            <td>
                                                <?php echo $registro->PROYECTO_NOMBRE; ?>
                                            </td>                                              
                                            <td>
                                                <a href="<?php echo base_url('document/edit/' . encrypt_id($registro->CONTRATO_ID)) ?>" class="btn default btn-xs red">
                                                    <i class="fa fa-edit"></i> 
                                                    Cargar Archivos
                                                </a>
                                                <a href="<?php echo base_url('document/documents/' . encrypt_id($registro->CONTRATO_ID)) ?>" class="btn default btn-xs yellow">
                                                    <i class="fa fa-folder-open"></i> 
                                                    Ver Info. / Gestionar Archivos 
                                                </a>                                               
                                            </td>                                        
                                        </tr>
                                        <?php
                                        $count++;
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
