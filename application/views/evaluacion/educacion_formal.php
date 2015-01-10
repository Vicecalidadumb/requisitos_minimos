<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h2 class="page-title">
            TITULO
        </h2>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo base_url('ruta') ?>">
                        ORDEN 1
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
                <h1>VERIFICACION DE REQUISITOS MINIMOS<br> CONVOCATORIA No. 320 de 2014 DPS</h1>
            </div>
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
                tabla
            </div>
            <p><br>
            <div class="col-md-12 col-sm-12">
                <h2 class="titulo3">DOCUMENTOS DE EDUCACIÓN </h2>
            </div>
            <div class="col-md-12 col-sm-12">
                <h2 class="tituloR">EDUCACIÓN FORMAL</h2>
            </div>
            <div class="col-md-12 col-sm-12">
                tabla <br>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#opcion" data-accion="editar" data-id="dd">Productos</button>
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

<div class="modal fade" id="opcion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id="remover" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">titulo</h4>
            </div>
            <div class="modal-body">
                <div id="contenido"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="guardar">Guardar</button>
                <!--<button type="button" class="btn btn-primary">Send message</button>-->
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