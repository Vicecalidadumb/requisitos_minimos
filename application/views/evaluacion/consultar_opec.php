<div class="row">
    <div class="col-md-12 col-sm-12" >
        <h3>
            <!--            OPEC - Convocatoria:-->
            <span id="ctl00_ContentPlaceHolder1_lblConvocatoria"></span>
        </h3>
        <p class="Nota" align='center'>
            <strong >A continuación se presenta la información básica del aspirante, de la entidad y del empleo seleccionado al momento de realizar la inscripción.</strong>
        </p>
        <h4 align='center'> Resultado de la Consulta.</h4>
    </div>
    <div class="col-md-12 col-sm-12" >
        <table class="table table-bordered table-striped">
            <tr>
                <td>
                    Nombres y apellidos
                </td>
                <td>
                    <?php echo $datos[0]->PRIMERNOMBRE_PER . " " . $datos[0]->SEGUNDONOMBRE_PER . " " . $datos[0]->PRIMERAPELLIDO_PER . " " . $datos[0]->SEGUNDOAPELLIDO_PER; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Tipo de documento:
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    Documento/PIN :
                </td>
                <td>
                    <?php echo $datos[0]->cedula . " / " . $datos[0]->PIN ?>
                </td>
            </tr>
            <tr>
                <td>
                    Género: 	
                </td>
                <td>
                    <?php echo ($datos[0]->IDGENERO_PER == 1) ? 'MASCULINO' : 'FEMENINO' ?>
                </td>
            </tr>
            <tr>
                <td>
                    Fecha / Municipio nacimiento: 	
                </td>
                <td>
                    <?php echo $datos[0]->FECHANACIMIENTO_PER ?>
                </td>
            </tr>
            <tr>
                <td>
                    Teléfonos de contacto:
                </td>
                <td>
                    <?php echo $datos[0]->TELEFONOFIJO_PER ?> - <?php echo $datos[0]->TELEFONOCEL_PER ?>
                </td>
            </tr>
            <tr>
                <td>
                    Correo electrónico: 
                </td>
                <td>
                    <?php echo $datos[0]->CORREO_PER ?>
                </td>
            </tr>
            <tr>
                <td>
                    Dirección: 
                </td>
                <td>
                    <?php echo $datos[0]->DIRECCION_PER ?>
                </td>
            </tr>
            <tr>
                <td>
                    Departamento/Municipio residencia: 	
                </td>
                <td>
                    <?php echo $datos[0]->DEPARTAMENTO_RESIDENCIA ?> / <?php echo $datos[0]->MUNICIPIO_RESIDENCIA ?>
                </td>
            </tr>
        </table>
    </div>