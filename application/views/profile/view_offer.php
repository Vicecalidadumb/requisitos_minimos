<link href="<?php echo base_url('/assets/admin/pages/css/profile.css'); ?>" rel="stylesheet" type="text/css"/>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
        Informaci&oacute;n de la <small>Oferta <?php echo 'UMB2014' . str_pad($oferta[0]->EMPLEO_ID, 4, "0", STR_PAD_LEFT); ?></small>
    </h4>
</div>


<div class="clearfix">
</div>

<div class="row ">
    <div class="col-md-12 col-sm-12">

        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>
                    <?php echo $oferta[0]->EMPLEO_DESCRIPCION; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row profile">


                    <div class="col-md-12">
                        <div class="bs-callout bs-callout-danger">
                            <h4><span class="glyphicon glyphicon-flag"></span> Perfil del Empleo</h4>
                            <p style="text-align: justify !important;">
                                <?php echo $oferta[0]->PERFIL; ?>
                            </p>
                        </div>
                        <div class="bs-callout bs-callout-info">
                            <h4><span class="glyphicon glyphicon-book"></span> Proposito</h4>
                            <p style="text-align: justify !important;">
                                <?php echo $oferta[0]->EMPLEO_PROPOSITO; ?>
                            </p>
                        </div>  
                    </div>

                    <div class="col-md-12">
                        <div class="bs-callout bs-callout-warning">
                            <h4><span class="glyphicon glyphicon-info-sign"></span> Detalles del Empleo</h4>
                            <table class="table table-striped">
                                <tr>
                                    <td style="width: 30%"><strong>Codigo del Empleo</strong></td>
                                    <td>
                                        <?php echo 'UMB2014' . str_pad($oferta[0]->EMPLEO_ID, 4, "0", STR_PAD_LEFT); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Salario</strong></td>
                                    <td>
                                        <?php echo '$' . number_format($oferta[0]->EMPLEO_SALARIO, 0, "'", '.'); ?>
                                    </td>                         
                                </tr>
                                <tr>
                                    <td><strong>Grado</strong></td>
                                    <td>
                                        <?php echo $oferta[0]->EMPLEO_GRADO ?>
                                    </td>                         
                                </tr>
                                <tr>
                                    <td><strong>Vacantes</strong></td>
                                    <td>
                                        <?php echo $oferta[0]->EMPLEO_VACANTES ?>
                                    </td>                         
                                </tr> 
                                <tr>
                                    <td><strong>Experiencia</strong></td>
                                    <td>
                                        <?php echo $oferta[0]->EMPLEO_EXPERIENCIA ?>
                                    </td>                         
                                </tr>                    
                                <tr>
                                    <td>
                                        <strong>Regiones</strong>
                                    </td>
                                    <td>
                                        <?php
                                        $ARRAY_regiones = explode('-', $oferta[0]->REGIONES);
                                        foreach ($ARRAY_regiones as $region) {
                                            ?>
                                            <a class="btn btn-default" style="margin-bottom: 2px;">
                                                <?php echo $region; ?>
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </td>                         
                                </tr>
                            </table>
                        </div>            
                    </div>

                    <div class="col-md-12">
                        <div class="bs-callout bs-callout-danger">
                            <h4><span class="glyphicon glyphicon-tasks"></span> Actividades</h4>
                            <ul class="list-group">
                                <?php foreach ($oferta as $actividad) { ?>
                                    <li class="list-group-item">
                                        <span class="glyphicon glyphicon-ok-circle"></span> <?php echo $actividad->ACTIVIDAD_NOMBRE; ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>   

                </div>

            </div>
        </div>

    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
</div>

