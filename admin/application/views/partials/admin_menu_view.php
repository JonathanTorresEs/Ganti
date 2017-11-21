<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="<?php echo base_url(); ?>"><img class="img-responsive" src="<?=base_url()?>/public/img/logo-nuevo.png" alt="ganti logo" style="max-width: 200px; max-height: 300px;"/></a>
    </div>

    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown pull-right">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> <?= $this->session->userdata('username') ?></a>
                </li>
                <li><a href="#"><i class="fa fa-cog fa-fw"></i> Configurar</a>
                </li>
                <li class="divider"></li>
                <li><?=anchor('login/logout_ci', '<i class="fa fa-sign-out fa-fw"></i> Salir') ?>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->


    <div class="navbar-default sidebar" role="navigation" id="sideBar">



        <div class="sidebar-nav navbar-collapse" style="width: 50px;">

            <!----- Icons only ---->
            <div onmouseover="openMenu()" onmouseout="closeMenu()" id="side-menu">
            <ul class="nav" id="side-menu" >
                <li>
                    <?=anchor('admin', '<i class="fa fa-dashboard fa-fw"></i> <p class="menuText" style="display: none"> Dashboard </p>') ?>
                </li>
                <li>
                    <?=anchor('requesition', '<i class="fa fa-shopping-cart fa-fw"></i> <p class="menuText" style="display: none"> Requisiciones </p>') ?>
                </li>
                <li>
                    <?=anchor('order', '<i class="fa fa-shopping-cart fa-fw"></i> <p class="menuText" style="display: none"> Ordenes </p>') ?>
                </li>
                <li>
                    <?=anchor('controles', '<i class="fa fa-flask fa-fw"></i> <p class="menuText" style="display: none"> Mantenimiento </p>') ?>
                </li>
                <li>
                    <?=anchor('produccion', '<i class="fa fa-gavel fa-fw"></i> <p class="menuText" style="display: none"> Producción </p>') ?>
                </li>

                <li>
                    <?=anchor('tareas', '<i class="fa fa-book fa-fw"></i> <p class="menuText" style="display: none"> Tareas </p>') ?>
                </li>

                <li>
                    <?=anchor('usos', '<i class="fa fa-exchange fa-fw"></i> <p class="menuText" style="display: none"> Usos </p>') ?>
                </li>
                <li>
                    <?=anchor('bitacoras', '<i class="fa fa-table fa-fw"></i> <p class="menuText" style="display: none"> Seguridad </p>') ?>
                </li>
                <li>
                    <div id="dropdownDiv" onmouseover="openDropdownDiv()">
                        <div class="toggle">
                            <i class="fa fa-dot-circle-o fa-fw"></i> <p class="menuText" style="display: none"> Bases de Datos </p> <span class="caret" id="dropdownArrow" style="display: none;"></span>
                        </div>
                        <div class="dropdown" id="dropdownList">
                            <?=anchor('maquinas', '<i class="fa fa-cogs fa-fw"></i> Equipos') ?>
                            <?=anchor('minas', '<i class="fa fa-sitemap fa-fw"></i> Localizacion') ?>
                            <?=anchor('clientes', '<i class="fa fa-credit-card fa-fw"></i> Clientes') ?>
                            <?=anchor('costos', '<i class="fa fa-cubes fa-fw"></i> Centro de Costos') ?>
                            <?=anchor('giros', '<i class="fa fa-cubes fa-fw"></i> Giros') ?>
                            <?=anchor('productos', '<i class="fa fa-cubes fa-fw"></i> Productos') ?>
                            <?=anchor('proveedores', '<i class="fa fa-truck fa-fw"></i> Proveedores') ?>
                            <!--   <?=anchor('tarjetas', '<i class="fa fa-credit-card fa-fw"></i> Tarjetas') ?> -->
                            <?php if ($this->session->userdata('profile') == 'Administrador' || $this->session->userdata('profile') == 'Compras') { ?>
                                <?=anchor('usuarios', '<i class="fa fa-users fa-fw"></i> Usuarios') ?>
                            <?php } ?>
                            <?php if ($this->session->userdata('username') == 'amontes@ganti.com.mx' or $this->session->userdata('profile') == 'Compras' or $this->session->userdata('profile') == 'Administrador') { ?>
                                <?=anchor('empleados', '<i class="fa fa-male fa-fw"></i> Empleados') ?>
                            <?php } ?>
                        </div>
                    </div>

                </li>
            </ul>
            </div>


            </div>

        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>