<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <h3 class="page-title">
            Aspirantes
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a>
                        Listado
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
                ....
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->