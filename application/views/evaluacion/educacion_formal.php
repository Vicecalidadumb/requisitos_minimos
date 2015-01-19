<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h2 class="page-title">
            VERIFICACION DE REQUISITOS MINIMOS<br> CONVOCATORIA No. 320 de 2014 DPS
        </h2>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo base_url('index.php/aspirantes') ?>">
                        Listado de Aspirantes
                    </a>
                </li>
                <li>
                    <i class="fa fa-angle-right"></i>
                    <a onclick="cambio_pagina(3, 1)" style="cursor: pointer">
                        Evaluar Educaci&oacute;n
                    </a>
                </li>
                <li>
                    <i class="fa fa-angle-right"></i>
                    <a onclick="cambio_pagina(3, 2)" style="cursor: pointer">
                        Evaluar Experiencia
                    </a>
                </li>
                <li>
                    <i class="fa fa-angle-right"></i>
                    <a onclick="cambio_pagina(3, 3)" style="cursor: pointer">
                        Evaluar Requisitos Minimos
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

            <div class="col-md-12 col-sm-12" align='center'>
                <h2 class="titulo3">DATOS DEL ASPIRANTE</h2>
            </div>

            <div class="col-md-12 col-sm-12" align='center'>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>NOMBRE</td>
                        <td>
                            <?php echo $datos[0]->PRIMERNOMBRE_PER . " " . $datos[0]->SEGUNDONOMBRE_PER . " " . $datos[0]->PRIMERAPELLIDO_PER . " " . $datos[0]->SEGUNDOAPELLIDO_PER; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>PIN</td>
                        <td>
                            <?php echo $datos[0]->PIN ?>
                        </td>
                    </tr>
                    <tr>
                        <td>EMPLEO</td>
                        <td>
                            <?php echo $datos[0]->idperfil_emp ?>
                        </td>
                    </tr>
                    <tr>
                        <td>NIVEL</td>
                        <td>
                            <?php echo $datos[0]->NOMBRE_NIVEL ?>
                        </td>
                    </tr>
                    <tr>
                        <td>REQUISITOS ESTUDIOS</td>
                        <td>
                            <?php echo $datos[0]->contextualizacion_0_req ?>
                        </td>
                    </tr>
                    <tr>
                        <td>EQUIVALENCIA</td>
                        <td>
                            <?php echo $datos[0]->contextualizacion_1_req ?>
                        </td>
                    </tr>
                    <tr>
                        <td>EXPERIENCIA</td>
                        <td>
                            <?php echo $datos[0]->experiencia_req ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12 col-sm-12" align='center'>
                <button type="button" class="btn btn-success opcion" data-toggle="modal" data-target="#opcion" data-accion="consultar_opec" data-id="<?php echo $get['id'] ?>">
                    Consultar Opec
                </button>
            </div>

            <div id="formulario_1">
                <?php echo $doc_espeficifos; ?>
                <div id="formulario_1_1">
                    <?php echo $doc_educacion; ?>
                </div>
            </div>

            <div id="formulario_2">
                <?php echo $doc_experiencia; ?>
            </div>
            <div id="formulario_3" style="display: none">
                <form id="form_final" method="post">
                    <input type="hidden" id="id_inscripcion" name="id_inscripcion" value="<?php echo $get['id'] ?>">
                    <div >
                        <?php echo $obtener_titulo; ?>
                        <!--aka va la el formulario de Requisitos Minimos de Estudio-->
                        <div>
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-2 col-sm-2"></div>
                                <div class="col-md-2 col-sm-2"></div>
                                <div class="col-md-2 col-sm-2">
                                    SI&nbsp;&nbsp;<?php echo form_radio('requisitos_minimo', "Admitido", false, 'class="requisitos_minimo "') ?>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    NO&nbsp;&nbsp;<?php echo form_radio('requisitos_minimo', "No Admitido", true, 'class="requisitos_minimo "') ?>
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
                        </div>
                        <!--fin del formulario Cumple Requisitos Minimos de Estudio--> 
                    </div>
                    <div >
                        <?php echo $obtener_experiencia; ?>
                    </div>
                    <div>
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-2 col-sm-2"></div>
                            <div class="col-md-2 col-sm-2"></div>
                            <div class="col-md-2 col-sm-2">
                                SI&nbsp;&nbsp;<?php echo form_radio('requisitos_experiencia', "Admitido", false, 'class="requisitos_experiencia "') ?>
                            </div>
                            <div class="col-md-2 col-sm-2">
                                NO&nbsp;&nbsp;<?php echo form_radio('requisitos_experiencia', "No Admitido", true, 'class="requisitos_experiencia "') ?>
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
                    </div>
                </form>
                <button id="guardar_rm" class="btn green" align="center">Guardar RM</button>
            </div>

            <div class="col-md-12 col-sm-12">
                <ul class="pager">
                    <li class="previous">
                        <a class="btn green" onclick="cambio_pagina(0)">
                            <i class="fa fa-angle-left"></i> Anterior 
                        </a>
                    </li>
                    <li class="next">
                        <a class="btn green" onclick="cambio_pagina(1)">
                            Siguiente <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url('/js/script_evaluacion.js'); ?>"></script>
