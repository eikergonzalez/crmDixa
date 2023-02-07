<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <!-- Logo -->
            <a class="fw-semibold text-white tracking-wide" href="/">
                <img src="{{ asset('images/logodixa.png')}}" width="210"/>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>
                <!-- <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#sidebar-style-toggler" data-class="fa-toggle-off fa-toggle-on" onclick="Dashmix.layout('sidebar_style_toggle');Dashmix.layout('header_style_toggle');">
                    <i class="fa fa-toggle-off" id="sidebar-style-toggler"></i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle" data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
                    <i class="far fa-moon" id="dark-mode-toggler"></i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button> -->
            </div>
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('agenda') ? ' active' : '' }}" href="/agenda">
                        <i class="nav-main-link-icon far fa-calendar-alt"></i>
                        <span class="nav-main-link-name">Agenda</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('noticias') ? ' active' : '' }}" href="/pages/noticias">
                        <i class="nav-main-link-icon far fa-list-alt"></i>
                        <span class="nav-main-link-name">Noticias</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('valoracion') ? ' active' : '' }}" href="/valoracion">
                        <i class="nav-main-link-icon fa fa-balance-scale-left"></i>
                        <span class="nav-main-link-name">Valoración</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('encargo') ? ' active' : '' }}" href="/encargo">
                        <i class="nav-main-link-icon fa fa-home"></i>
                        <span class="nav-main-link-name">Encargo</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('pedidos') ? ' active' : '' }}" href="/pedidos">
                        <i class="nav-main-link-icon fa fa-user-friends"></i>
                        <span class="nav-main-link-name">Pedidos</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('firma-pendiente') ? ' active' : '' }}" href="/firma-pendiente">
                        <i class="nav-main-link-icon far fa-clock"></i>
                        <span class="nav-main-link-name">Firma Pendiente</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('de-baja') ? ' active' : '' }}" href="/de-baja">
                        <i class="nav-main-link-icon fa fa-folder-minus"></i>
                        <span class="nav-main-link-name">De baja</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('operaciones-cerradas') ? ' active' : '' }}" href="/operaciones-cerradas">
                        <i class="nav-main-link-icon fa fa-th-large"></i>
                        <span class="nav-main-link-name">Op. Cerradas</span>
                    </a>
                </li>
                <li class="nav-main-item{{ request()->is('informe/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-file-alt"></i>
                        <span class="nav-main-link-name">Informe</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('informe/main') ? ' active' : '' }}" href="/informe/main">
                                <span class="nav-main-link-name">#####</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-item{{ request()->is('ajustes/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-cog"></i>
                        <span class="nav-main-link-name">Ajustes</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('ajustes/usuarios') ? ' active' : '' }}" href="/ajustes/usuarios">
                                <span class="nav-main-link-name">Usuarios</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('ajustes/roles') ? ' active' : '' }}" href="/ajustes/roles">
                                <span class="nav-main-link-name">Roles</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
      <!-- END Sidebar Scrolling -->
</nav>