<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">

                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <!--            class="start active open"-->
            <br>
            <li class="<?php echo strstr($content, 'desk') ? 'active open' : ''; ?>">
                <a href="<?php echo base_url('index.php/desk'); ?>">
                    <i class="icon-home"></i>
                    <span class="title">Inicio</span>
                </a>
            </li>

            

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>