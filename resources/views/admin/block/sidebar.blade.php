<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/admincp" class="brand-link d-flex align-items-center justify-content-center" style="height: 3.5rem;" aria-label="Comp.MD — pagina principală admin">
        <img src="/logo.png" alt="CompMD" class="brand-image elevation-3 m-0" style="opacity: .8; max-width: 100%; min-width: 0; object-fit: contain;">
    </a>
    <div class="sidebar">
        @php($sidebarUserName = Auth::user()->name ?? 'Admin')
        <div class="user-panel sidebar-user-panel mt-3 mb-3 py-2 d-flex align-items-center">
            <div class="image flex-shrink-0">
                <span class="sidebar-user-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(trim($sidebarUserName), 0, 1)) }}</span>
            </div>
            <div class="info">
                <span class="sidebar-user-name d-block text-truncate" title="{{ $sidebarUserName }}">{{ $sidebarUserName }}</span>
                <small class="sidebar-user-caption d-block">Cont autentificat</small>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Produse<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('category.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categorii</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('products.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Produse</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('pages.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pagini</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>B2B Accent<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('b2b_folders')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Accent Category</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>Service Center<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('service.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Comenzi reparatii</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('service.clients')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Clienti</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('service.device-types')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tipuri dispozitive</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-server"></i>
                        <p>Hosting & Domenii<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('hosting.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Servicii clienti</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('hosting.packages')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pachete hosting</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Setari<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('bannerblock.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Bannere</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sliders.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slidere</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.telegram')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Telegram notificari</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.translate.settings')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Traducere DeepL</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.schedule')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Program de lucru</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Utilizatori<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.users.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista utilizatori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.roles.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roluri / Grupe</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('cash.index') }}" class="nav-link {{ request()->routeIs('cash.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>Casă</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
