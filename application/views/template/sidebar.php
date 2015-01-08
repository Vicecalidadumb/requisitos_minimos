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

            <?php if (know_permission_role('USU', 'permission_view')): ?>
                <li class="<?php echo strstr($content, 'user') ? 'active open' : ''; ?>">
                    <a href="javascript:;">
                        <i class="icon-user"></i>
                        <span class="title">Usuarios del Sistema</span>
                        <?php echo strstr($content, 'user') ? '<span class="selected"></span>' : ''; ?>
                        <span class="arrow <?php echo strstr($content, 'user') ? 'open' : ''; ?>"></span>
                    </a>                   
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('index.php/user'); ?>">
                                Listado de Usuarios
                            </a>
                        </li>
                        <?php if (know_permission_role('USU', 'permission_add')): ?>
                            <li>
                                <a href="<?php echo base_url('index.php/user/add'); ?>">
                                    Agregar Usuario
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>            

            <?php if (know_permission_role('PER', 'permission_view')): ?>
                <li class="<?php echo strstr($content, 'profile') ? 'active open' : ''; ?>">
                    <a href="javascript:;">
                        <i class="icon-graduation"></i>
                        <span class="title">
                            <?php if ($this->session->userdata('ID_TIPO_USU') != 3) { ?>
                                Perfilamiento
                            <?php } else { ?>
                                Aspirantes
                            <?php } ?>
                        </span>
                        <?php echo strstr($content, 'profile') ? '<span class="selected"></span>' : ''; ?>
                        <span class="arrow <?php echo strstr($content, 'user') ? 'open' : ''; ?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('index.php/profile'); ?>">
                                Listado de Aspirantes
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (know_permission_role('ROL', 'permission_view')): ?>
                <li class="<?php echo strstr($content, 'config') ? 'active open' : ''; ?>">
                    <a href="javascript:;">
                        <i class="icon-settings"></i>
                        <span class="title">Sistema</span>
                        <?php echo strstr($content, 'config') ? '<span class="selected"></span>' : ''; ?>
                        <span class="arrow <?php echo strstr($content, 'config') ? 'open' : ''; ?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('index.php/config/roles'); ?>">
                                Roles
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (know_permission_role('EST', 'permission_view')): ?>
                <li class="<?php echo strstr($content, 'statistics') ? 'active open' : ''; ?>">
                    <a href="javascript:;">
                        <i class="icon-bar-chart"></i>
                        <span class="title">Reportes</span>
                        <?php echo strstr($content, 'statistics') ? '<span class="selected"></span>' : ''; ?>
                        <span class="arrow <?php echo strstr($content, 'statistics') ? 'open' : ''; ?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url('index.php/statistics/reporte1'); ?>">
                                Evaluados
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>