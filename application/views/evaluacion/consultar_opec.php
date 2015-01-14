<div class="row">
    <?php //echo print_y($datos); ?>
    <div class="col-md-12 col-sm-12" >
        <h3>
            <!--            OPEC - Convocatoria:-->
            <span id="ctl00_ContentPlaceHolder1_lblConvocatoria"></span>
        </h3>
        <p class="Nota" align='center'>
            <strong >A continuación se presenta la información básica del aspirante, de la entidad y del empleo seleccionado al momento de realizar la inscripción.</strong>
        </p>
        
        <h4 align='center'> Datos personales del aspirante</h4>

        <table class="table table-bordered table-striped">
            <tr>
                <td>Nombres y apellidos</td>
                <td>
                    <?php echo $datos[0]->PRIMERNOMBRE_PER . " " . $datos[0]->SEGUNDONOMBRE_PER . " " . $datos[0]->PRIMERAPELLIDO_PER . " " . $datos[0]->SEGUNDOAPELLIDO_PER; ?>
                </td>
            </tr>
            <tr>
                <td>Tipo de documento:</td>
                <td>
                    <?php echo $datos[0]->TIPO_DOCUMENTO ?>
                </td>
            </tr>
            <tr>
                <td>Documento/PIN :</td>
                <td>
                    <?php echo $datos[0]->DOCUMENTO_PER . " / " . $datos[0]->PIN ?>
                </td>
            </tr>
            <tr>
                <td>Género:</td>
                <td>
                    <?php echo ($datos[0]->IDGENERO_PER == 1) ? 'MASCULINO' : 'FEMENINO' ?>
                </td>
            </tr>
            <tr>
                <td>Fecha / Municipio nacimiento:</td>
                <td>
                    <?php echo $datos[0]->FECHANACIMIENTO_PER ?>
                </td>
            </tr>
            <tr>
                <td>Teléfonos de contacto:</td>
                <td>
                    <?php echo $datos[0]->TELEFONOFIJO_PER ?> - <?php echo $datos[0]->TELEFONOCEL_PER ?>
                </td>
            </tr>
            <tr>
                <td>Correo electrónico:</td>
                <td>
                    <?php echo $datos[0]->CORREO_PER ?>
                </td>
            </tr>
            <tr>
                <td>Dirección:</td>
                <td>
                    <?php echo $datos[0]->DIRECCION_PER ?>
                </td>
            </tr>
            <tr>
                <td>Departamento/Municipio residencia:</td>
                <td>
                    <?php echo $datos[0]->DEPARTAMENTO_RESIDENCIA ?> / <?php echo $datos[0]->MUNICIPIO_RESIDENCIA ?>
                </td>
            </tr>
        </table>
        
        <h4 align='center'> Datos del Empleo</h4>
        
        <table class="table table-bordered table-striped">
            <tr>
                <td>Entidad:</td>
                <td>
                    <?php echo $datos[0]->nombre_ent ; ?>
                </td>
            </tr>
            <tr>
                <td>Número de empleo CNSC:</td>
                <td>
                    <?php echo $datos[0]->IDPERFIL_REG ; ?>
                </td>
            </tr>
            <tr>
                <td>Denominación:</td>
                <td>
                    <?php echo $datos[0]->denominacion_coe ; ?>
                </td>
            </tr>
            <tr>
                <td>Asignación Salarial:</td>
                <td>
                    $<?php echo number_format($datos[0]->asignac_salarial_per,3,'.',',') ; ?>
                </td>
            </tr>
            <tr>
                <td>Código:</td>
                <td>
                    <?php echo $datos[0]->codigo_coe ; ?>
                </td>
            </tr>
            <tr>
                <td>Grado:</td>
                <td>
                    <?php echo $datos[0]->grado_per ; ?>
                </td>
            </tr>
            <tr>
                <td>Nivel jerárquico:</td>
                <td>
                    <?php echo $datos[0]->nombre_nivel ; ?>
                </td>
            </tr>
        </table>
        
        <h4 align='center'> Dependencia</h4>
        
        <table class="table table-bordered table-striped">
            <tr>
                <td>Dependencia:</td>
                <td>
                    <?php echo $datos[0]->nomdepen_dep ; ?>
                </td>
            </tr>
            <tr>
                <td>Propósito principal del empleo:</td>
                <td>
                    <?php echo $datos[0]->proposito_per ; ?>
                </td>
            </tr>
            <tr>
                <td>Requisitos de Estudio:</td>
                <td>
                    <?php echo str_replace('.', '.<br>', $datos[0]->contextualizacion_0_req) ; ?>
                </td>
            </tr>
            <tr>
                <td>Requisitos de Experiencia:</td>
                <td>
                    <?php echo $datos[0]->experiencia_req ; ?>
                </td>
            </tr>
            <tr>
                <td>Equivalencia:</td>
                <td>
                    <?php echo str_replace('.', '.<br>', $datos[0]->contextualizacion_1_req) ; ?>
                </td>
            </tr>
            
        </table>
    </div>
</div>