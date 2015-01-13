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
                    <a href="<?php echo base_url('index.php') ?>">
                        Inicio
                    </a>
                </li>
                <li>
                    <i class="fa fa-angle-right"></i>
                    <a href="<?php echo base_url('index.php/evaluacion?id='.$_GET['id']) ?>">
                        DATOS DEL ASPIRANTE
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
            <p>
            <div class="col-md-12 col-sm-12" align='center'>
                <h2 class="titulo3">DATOS DEL ASPIRANTE</h2>
            </div>
            <div class="col-md-12 col-sm-12" align='center'>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>
                            NOMBRE
                        </td>
                        <td>
                            <?php echo $datos[0]->PRIMERNOMBRE_PER . " " . $datos[0]->SEGUNDONOMBRE_PER . " " . $datos[0]->PRIMERAPELLIDO_PER . " " . $datos[0]->SEGUNDOAPELLIDO_PER; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            PIN
                        </td>
                        <td>
                            <?php echo $datos[0]->PIN ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            EMPLEO
                        </td>
                        <td>
                            <?php echo $datos[0]->idperfil_emp ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            NIVEL
                        </td>
                        <td>
                            <?php echo $datos[0]->NOMBRE_NIVEL ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            REQUISITOS ESTUDIOS 
                        </td>
                        <td>
                            <?php echo $datos[0]->contextualizacion_0_req ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            EQUIVALENCIA
                        </td>
                        <td>
                            <?php echo $datos[0]->contextualizacion_1_req ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            EXPERIENCIA
                        </td>
                        <td>
                            <?php echo $datos[0]->experiencia_req ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12 col-sm-12" align='center'>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#opcion" data-accion="consultar_opec" data-id="<?php echo $get['id'] ?>">Consultar Opec</button>
            </div>

            <p><br>
            <div class="col-md-12 col-sm-12">
                <h2 class="titulo3">DOCUMENTOS ESPECÍFICOS DE LA CONVOCATORIA </h2>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="col-md-2 col-sm-2"></div>
                <div class="col-md-8 col-sm-8">
                    <table class="table table-bordered table-striped">
                        <thead><th>N. Folio</th><th>Documento</th><th>Folio</th></thead>
                        <?php
                        $i = 0;
                        foreach ($documentos as $documentos2) {
                            $archivo = str_replace('~/', 'http://172.16.210.37/rmdps/', $documentos2->RUTAADJUNTO_DOC);
                            echo "<tr><td>" . ++$i . "</td><td>" . $documentos2->DETALLEPARAMETRO_PAR . '</td><td><a target="_blank" href="' . $archivo . '">Ver Folio..</a></td></tr>';
                        }
                        ?>
                    </table>
                </div>
                <div class="col-md-2 col-sm-2"></div>
            </div>
            <p><br>
            <div class="col-md-12 col-sm-12">
                <h2 class="titulo3">DOCUMENTOS DE EDUCACIÓN </h2>
            </div>
            <div class="col-md-12 col-sm-12">
                <h2 class="tituloR">EDUCACIÓN FORMAL</h2>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="col-md-2 col-sm-2"></div>
                <div class="col-md-8 col-sm-8">
                    <table class="table table-bordered table-striped">
                        <thead><th>N. Folio</th><th>Documento</th><th>Folio</th><th>Modificar</th></thead>
                        <?php
                        $i = 0;
                        foreach ($educacion_formal as $documentos2) {
                            $archivo = str_replace('~/', 'http://172.16.210.37/rmdps/', $documentos2->RUTAADJUNTO_CRA);
                            echo "<tr><td>" . $documentos2->CONSECUTIVO_CRA . "</td><td>" . $documentos2->MODALIDAD_MOD . '</td><td><a target="_blank" href="' . $archivo . '">Ver Folio..</a></td><td align="center"><button type="button" class="btn defaul btn-xs"  data-toggle="modal" data-target="#opcion" data-accion="editar" data-id="'.$documentos2->CONSECUTIVO_CRA.'"><i class="glyphicon glyphicon-pencil"></i></button></td></tr>';
                        }
                        ?>
                    </table>
                </div>
                <div class="col-md-2 col-sm-2"></div>
            </div>
            <p><br>
            <div class="col-md-12 col-sm-12">
                <button>Nuevo Folio</button>
            </div>
            <p><br>
            <div class="col-md-12 col-sm-12">
                <h2 class="titulo3">EDUCACIÓN PARA EL TRABAJO Y EL DESARROLLO HUMANO </h2>
            </div>
        </div>   

    </div>
</div>
<script>
    $('#opcion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var accion = button.data('accion')
        $('#contenido').html('')
        var titulo = "";
        var url = "";
        var id = "";

        switch (accion) {
            case 'editar':
                titulo = '<h5><i class="glyphicon glyphicon-pencil"></i> Nuevo</h5>';
                url = '<?php echo base_url('index.php'); ?>/evaluacion/calificar_modalidad';
                $("#remover").removeClass('modal-lg modal-full').addClass('');
                $('#guardar').show();
                break;
            case 'consultar_opec':
                titulo = '<h3><i class="icon-graduation" style=" font-size:30px"></i> OPEC - Convocatoria:  </h3>';
                url = '<?php echo base_url('index.php'); ?>/evaluacion/consultar_opec';
                $("#remover").removeClass('modal-lg modal-full').addClass('modal-lg');
                $('#guardar').hide();
                break;
        }

        id = button.data('id')

        $.post(url, {id: id})
                .done(function (msg) {
                    $('#contenido').html(msg)
                }).fail(function (msg) {
            alert('Error al traer la información');
        })


//        var recipient = button.data('id') 
        var modal = $(this)
        modal.find('.modal-title').html(titulo)
    });
</script>

<!-- END CONTENT -->