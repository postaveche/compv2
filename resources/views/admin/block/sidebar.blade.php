<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/admincp" class="brand-link">
        <img src="/logo.png" alt="CompMD" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Comp.MD</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Admin' }}</a>
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

            </ul>
        </nav>
    </div>
</aside>
