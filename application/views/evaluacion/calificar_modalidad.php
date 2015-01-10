<div class="row">
    <div class="col-md-12 col-sm-12" >
        <div class="col-md-3 col-sm-3" >
            Modalidad
        </div>
        <div class="col-md-9 col-sm-9" >
            <?php echo form_dropdown($data="nelson", array("s"=>"1" ),'' ,$extra='style="width: 100%;"') ?>
            <?php echo form_dropdown($data="nelson", array("s"=>"sem" ),'', $extra='style="width: 100%;"') ?>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" >
        <div class="col-md-3 col-sm-3" >
             Graduado 
        </div>
        <div class="col-md-2 col-sm-2" >
            <?php echo  form_checkbox("graduado", "1", false) ?>
        </div>
        <div class="col-md-4 col-sm-4" >
             Obtenido en el Extranjero 
        </div>
        <div class="col-md-1 col-sm-1" >
            <?php echo  form_checkbox("graduado_ext", "1", false) ?>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" >
        <div class="col-md-3 col-sm-3" >
            Universidad o Institución
        </div>
        <div class="col-md-9 col-sm-9" >
            <?php echo form_dropdown($data="universidad", array("-1"=>"" ),'', $extra='style="width: 100%;"') ?>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" >
        <div class="col-md-3 col-sm-3" >
            Título
        </div>
        <div class="col-md-9 col-sm-9" >
            <?php echo form_dropdown($data="titulo", array("-1"=>"" ),'', $extra='style="width: 100%;"') ?>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" >
        <div class="col-md-3 col-sm-3" >
            Fecha Terminación 	
        </div>
        <div class="col-md-9 col-sm-9" >
            <?php echo form_dropdown($data="fecha_terminacion", array("-1"=>"" ),'',$extra='style="width: 100%;"') ?>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" >
        <div class="col-md-3 col-sm-3" >
            Fecha Grado
        </div>
        <div class="col-md-9 col-sm-9" >
            <?php echo form_dropdown('fecha_grado', array("-1"=>"" ), '',$extra='style="width: 100%;"') ?>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" >
        <div class="col-md-3 col-sm-3" >
            Observaciones
        </div>
        <div class="col-md-9 col-sm-9" >
            <?php echo form_textarea('observaciones', $value="", $extra='style="width: 100%; height: 75px;"') ?>
        </div>
    </div>
</div>