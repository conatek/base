<div class="scrollbar-sidebar">
    <div class="app-sidebar__inner">
        <ul class="vertical-nav-menu">
            @can('block_company')
            <li class="app-sidebar__heading" style="color: white !important;">Gestión de Empresa</li>

                @can('home_index')
                <li class="{{ request()->is('home') ? 'mm-active' : '' }}">
                    <a href="{{ route('home') }}" class="{{ request()->is('home') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-chart-line"></i>
                        Panel de Control
                    </a>
                </li>
                @endcan

                @can('companies_index')
                <li class="{{ request()->is('companies*') ? 'mm-active' : '' }}">
                    <a href="{{ route('companies.index') }}" class="{{ request()->is('companies*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-building"></i>
                        Empresas
                    </a>
                </li>
                @endcan

                @can('roles_index')
                <li class="{{ request()->is('roles*') ? 'mm-active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="{{ request()->is('roles*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-key"></i>
                        Roles y Permisos
                    </a>
                </li>
                @endcan

                @can('users_index')
                <li class="{{ request()->is('users*') ? 'mm-active' : '' }}">
                    <a href="{{ route('users.index') }}" class="{{ request()->is('users*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-users"></i>
                        Usuarios
                    </a>
                </li>
                @endcan

                @can('company_index')
                <li class="{{ request()->is('company*') ? 'mm-active' : '' }}">
                    <a href="{{ route('company.show') }}" class="{{ request()->is('company*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-sitemap"></i>
                        Organización
                    </a>
                </li>
                @endcan

            <hr style="color: #fff;">

            @endcan

            @can('block_collaborators')
            <li class="app-sidebar__heading" style="color: white !important;">Gestión de Colaboradores</li>

                <li class="{{ request()->is('collaborators*') ? 'mm-active' : '' }}">
                    <a href="{{ route('collaborators.index') }}" class="{{ request()->is('collaborators*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-asterisk"></i>
                        Maestro
                    </a>
                </li>

                {{-- @can(['area_index']) --}}
                <li>
                    <a href="#" class="{{ request()->is('modules*') ? 'mm-active' : '' }}">
                        <i class="metismenu-icon fa fa-cube"></i>
                        Módulos
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li class="{{ request()->is('modules/selection*') ? 'mm-active' : '' }}">
                            <a href="{{ route('selection.index') }}" class="{{ request()->is('modules/selection*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon fa fa-toolbox"></i>
                                Procesos de Selección
                            </a>
                        </li>

                        <li class="{{ request()->is('modules/absence*') ? 'mm-active' : '' }}">
                            <a href="{{ route('absence.index') }}" class="{{ request()->is('modules/absence*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon fa fa-toolbox"></i>
                                Ausentismo
                            </a>
                        </li>

                        <li class="{{ request()->is('modules/provision*') ? 'mm-active' : '' }}">
                            <a href="{{ route('provision.index') }}" class="{{ request()->is('modules/provision*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon fa fa-toolbox"></i>
                                Dotación
                            </a>
                        </li>

                        <li class="{{ request()->is('modules/training*') ? 'mm-active' : '' }}">
                            <a href="{{ route('training.index') }}" class="{{ request()->is('modules/training*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon fa fa-toolbox"></i>
                                Planes de Formación
                            </a>
                        </li>

                        <li class="{{ request()->is('modules/performance*') ? 'mm-active' : '' }}">
                            <a href="{{ route('performance.index') }}" class="{{ request()->is('modules/performance*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon fa fa-toolbox"></i>
                                Evaluación de Desempeño
                            </a>
                        </li>

                        <li class="{{ request()->is('modules/wellness*') ? 'mm-active' : '' }}">
                            <a href="{{ route('wellness.index') }}" class="{{ request()->is('modules/wellness*') ? 'mm-active' : '' }}">
                                <i class="metismenu-icon fa fa-toolbox"></i>
                                Bienestar
                            </a>
                        </li>
                    </ul>
                </li>

            <hr style="color: #fff;">
            @endcan


            @can('block_self_management')
            <li class="app-sidebar__heading" style="color: white !important;">Autogestión</li>

            <li>
                <a href="#" class="{{ request()->is('tools*') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon fa fa-hand-point-up"></i>
                    Solicitudes
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul>
                    <li class="{{ request()->is('tools/overtime*') ? 'mm-active' : '' }}">
                        <a href="{{ route('overtime.index') }}" class="{{ request()->is('tools/overtime*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fa fa-toolbox"></i>
                            Certificados
                        </a>
                    </li>

                    <li class="{{ request()->is('tools/inventory*') ? 'mm-active' : '' }}">
                        <a href="{{ route('inventory.index') }}" class="{{ request()->is('tools/inventory*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon"></i>
                            Vacaciones
                        </a>
                    </li>

                    <li class="{{ request()->is('tools/cards*') ? 'mm-active' : '' }}">
                        <a href="{{ route('cards.index') }}" class="{{ request()->is('tools/cards*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon"></i>
                            Permisos
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('block_utilities')
            <hr style="color: #fff;">

            <li class="app-sidebar__heading" style="color: white !important;">Utilidades</li>

            <li>
                <a href="#" class="{{ request()->is('tools*') ? 'mm-active' : '' }}">
                    <i class="metismenu-icon fa fa-toolbox"></i>
                    Herramientas
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul>
                    <li class="{{ request()->is('tools/overtime*') ? 'mm-active' : '' }}">
                        <a href="{{ route('overtime.index') }}" class="{{ request()->is('tools/overtime*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon fa fa-toolbox"></i>
                            Control Horas Extras
                        </a>
                    </li>

                    <li class="{{ request()->is('tools/inventory*') ? 'mm-active' : '' }}">
                        <a href="{{ route('inventory.index') }}" class="{{ request()->is('tools/inventory*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon"></i>
                            Inventario
                        </a>
                    </li>

                    <li class="{{ request()->is('tools/cards*') ? 'mm-active' : '' }}">
                        <a href="{{ route('cards.index') }}" class="{{ request()->is('tools/cards*') ? 'mm-active' : '' }}">
                            <i class="metismenu-icon"></i>
                            Tarjetas
                        </a>
                    </li>
                </ul>
            </li>

            {{-- @can('cms_index') --}}
            <li class="{{ request()->is('cms*') ? 'mm-active' : '' }}">
                <a href="#">
                    <i class="metismenu-icon pe-7s-news-paper"></i>
                    CMS
                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                </a>
                <ul>
                    <li>
                        <a href="#">
                            <i class="metismenu-icon"></i>
                            Listado
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="metismenu-icon"></i>
                            Agregar
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
        </ul>
    </div>
</div>
