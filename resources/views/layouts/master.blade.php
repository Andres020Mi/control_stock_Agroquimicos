<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{asset('Adminlte/dist/css/adminlte.css')}}" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
      crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
      integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
      crossorigin="anonymous"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('links_css_head')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Start Navbar Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>

            {{-- <!-- Navigation Links según rol -->
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'instructor')
                <li class="nav-item">
                    <a href="{{ route('solicitudes_movimientos.index') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.index') ? 'active' : '' }}">
                        Solicitudes de movimientos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lideres_unidades.index') }}" class="nav-link {{ request()->routeIs('lideres_unidades.index') ? 'active' : '' }}">
                        Gestionar líderes de unidades
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.index') ? 'active' : '' }}">
                        Insumos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.index') ? 'active' : '' }}">
                        Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('movimientos.index') }}" class="nav-link {{ request()->routeIs('movimientos.index') ? 'active' : '' }}">
                        Movimientos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('unidades_de_produccion.index') }}" class="nav-link {{ request()->routeIs('unidades_de_produccion.index') ? 'active' : '' }}">
                        Unidades de Producción
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('almacenes.index') }}" class="nav-link {{ request()->routeIs('almacenes.index') ? 'active' : '' }}">
                        Almacenes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('proveedores.index') }}" class="nav-link {{ request()->routeIs('proveedores.index') ? 'active' : '' }}">
                        Proveedores
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        Administrar usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('solicitudes_movimientos.mis_solicitudes') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.mis_solicitudes') ? 'active' : '' }}">
                        Mis solicitudes
                    </a>
                </li>
            @elseif(Auth::user()->role == 'aprendiz' || Auth::user()->role == 'lider de la unidad')
                <li class="nav-item">
                    <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.index') ? 'active' : '' }}">
                        Insumos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.index') ? 'active' : '' }}">
                        Stock
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('movimientos.index') }}" class="nav-link {{ request()->routeIs('movimientos.index') ? 'active' : '' }}">
                        Movimientos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('unidades_de_produccion.index') }}" class="nav-link {{ request()->routeIs('unidades_de_produccion.index') ? 'active' : '' }}">
                        Unidades de Producción
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('almacenes.index') }}" class="nav-link {{ request()->routeIs('almacenes.index') ? 'active' : '' }}">
                        Almacenes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('proveedores.index') }}" class="nav-link {{ request()->routeIs('proveedores.index') ? 'active' : '' }}">
                        Proveedores
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('solicitudes_movimientos.mis_solicitudes') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.mis_solicitudes') ? 'active' : '' }}">
                        Mis solicitudes
                    </a>
                </li>
            @endif
                --}} 
        </ul>

        <!-- End Navbar Links -->
        <ul class="navbar-nav ms-auto">
            {{-- <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-chat-text"></i>
                    <span class="navbar-badge badge text-bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('Adminlte/dist/assets/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 rounded-circle me-3" />
                            </div>
                            <div class="flex-grow-1">
                                <h3 class="dropdown-item-title">Brad Diesel</h3>
                                <p class="fs-7">Call me whenever you can...</p>
                                <p class="fs-7 text-secondary"><i class="bi bi-clock-fill me-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li> --}}

            {{-- <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li> --}}

            <!-- Fullscreen Toggle -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li> 

            <!-- User Menu Dropdown -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('Adminlte/dist/assets/img/user2-160x160.png') }}" class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="{{ asset('Adminlte/dist/assets/img/user2-160x160.png') }}" class="rounded-circle shadow" alt="User Image" />
                        <p>
                            {{ Auth::user()->name }} - {{ ucfirst(Auth::user()->role) }}
                            <small>Miembro desde {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<style>
    .app-sidebar .nav-link p {
    white-space: normal; /* Permite que el texto se divida en varias líneas */
    overflow: visible; /* Evita que el texto se oculte */
    text-overflow: initial; /* Elimina los puntos suspensivos */
    max-width: none; /* Elimina restricciones de ancho máximo */
}

.app-sidebar .nav-link {
    display: flex;
    align-items: center;
    padding: 0.5rem 1rem; /* Ajusta el padding para dar espacio */
}

.app-sidebar .sidebar-menu {
    width: 250px; /* Aumenta el ancho del sidebar si es necesario */
}

/* Opcional: Ajusta el ancho del sidebar cuando está colapsado */
.app-sidebar.sidebar-mini.sidebar-collapse .sidebar-menu {
    width: 60px;
}

.app-sidebar.sidebar-mini.sidebar-collapse .nav-link p {
    display: none; /* Oculta el texto cuando el sidebar está colapsado */
}
</style>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('Adminlte/dist/assets/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image opacity-75 shadow" />
                <span class="brand-text fw-light">Agroquímicos</span>
            </a>
        </div>
    
        <!-- Sidebar Wrapper -->
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
    
                    <!-- Rutas para admin e instructor -->
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'instructor')
                        <li class="nav-item">
                            <a href="{{ route('solicitudes_movimientos.index') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>Solicitudes de movimientos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('lideres_unidades.index') }}" class="nav-link {{ request()->routeIs('lideres_unidades.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-gear"></i>
                                <p>Gestionar líderes de unidades</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p>Insumos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-archive-fill"></i>
                                <p>Stock</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('movimientos.index') }}" class="nav-link {{ request()->routeIs('movimientos.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-arrow-left-right"></i>
                                <p>Movimientos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('unidades_de_produccion.index') }}" class="nav-link {{ request()->routeIs('unidades_de_produccion.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-building"></i>
                                <p>Unidades de Producción</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('almacenes.index') }}" class="nav-link {{ request()->routeIs('almacenes.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p>Almacenes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('proveedores.index') }}" class="nav-link {{ request()->routeIs('proveedores.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-truck"></i>
                                <p>Proveedores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Administrar usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('solicitudes_movimientos.mis_solicitudes') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.mis_solicitudes') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-earmark-person"></i>
                                <p>Mis solicitudes</p>
                            </a>
                        </li>
                    @endif
    
                    <!-- Rutas para aprendiz y líder de la unidad -->
                    @if(Auth::user()->role == 'aprendiz' || Auth::user()->role == 'lider de la unidad')
                    <li class="nav-item">
                        <a href="{{ route('insumos.index') }}" class="nav-link {{ request()->routeIs('insumos.index') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-box-seam-fill"></i>
                            <p>Insumos</p>
                        </a>
                    </li>
                        <li class="nav-item">
                            <a href="{{ route('stocks.index') }}" class="nav-link {{ request()->routeIs('stocks.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-archive-fill"></i>
                                <p>Stock</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('movimientos.index') }}" class="nav-link {{ request()->routeIs('movimientos.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-arrow-left-right"></i>
                                <p>Movimientos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('unidades_de_produccion.index') }}" class="nav-link {{ request()->routeIs('unidades_de_produccion.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-building"></i>
                                <p>Unidades de Producción</p>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="{{ route('almacenes.index') }}" class="nav-link {{ request()->routeIs('almacenes.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p>Almacenes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('proveedores.index') }}" class="nav-link {{ request()->routeIs('proveedores.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-truck"></i>
                                <p>Proveedores</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('solicitudes_movimientos.mis_solicitudes') }}" class="nav-link {{ request()->routeIs('solicitudes_movimientos.mis_solicitudes') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-file-earmark-person"></i>
                                <p>Mis solicitudes</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
      @yield('content')
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer text-center py-3">
        <div class="container">
            <strong>© 2025 Gestión de Agroquímicos SENA. Todos los derechos reservados.</strong>
            <br>
            <small>Desarrollado por Andrés Gonzalo Barrera Cortés | Contacto: +57 316 820 9707 | andresgbarrerac@gmail.com </small>
            <br>
            <small>28/03/2025</small>
        </div>
    </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{asset('Adminlte/dist/js/adminlte.js')}}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
      src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
      integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
      crossorigin="anonymous"
    ></script>
    <!-- sortablejs -->
    <script>
      const connectedSortables = document.querySelectorAll('.connectedSortable');
      connectedSortables.forEach((connectedSortable) => {
        let sortable = new Sortable(connectedSortable, {
          group: 'shared',
          handle: '.card-header',
        });
      });

      const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
      cardHeaders.forEach((cardHeader) => {
        cardHeader.style.cursor = 'move';
      });
    </script>
    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>
    <!-- ChartJS -->
    <script>
      // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
      // IT'S ALL JUST JUNK FOR DEMO
      // ++++++++++++++++++++++++++++++++++++++++++

      const sales_chart_options = {
        series: [
          {
            name: 'Digital Goods',
            data: [28, 48, 40, 19, 86, 27, 90],
          },
          {
            name: 'Electronics',
            data: [65, 59, 80, 81, 56, 55, 40],
          },
        ],
        chart: {
          height: 300,
          type: 'area',
          toolbar: {
            show: false,
          },
        },
        legend: {
          show: false,
        },
        colors: ['#0d6efd', '#20c997'],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: 'smooth',
        },
        xaxis: {
          type: 'datetime',
          categories: [
            '2023-01-01',
            '2023-02-01',
            '2023-03-01',
            '2023-04-01',
            '2023-05-01',
            '2023-06-01',
            '2023-07-01',
          ],
        },
        tooltip: {
          x: {
            format: 'MMMM yyyy',
          },
        },
      };

      const sales_chart = new ApexCharts(
        document.querySelector('#revenue-chart'),
        sales_chart_options,
      );
      sales_chart.render();
    </script>
    <!-- jsvectormap -->
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
      integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
      integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
      crossorigin="anonymous"
    ></script>
    <!-- jsvectormap -->
    <script>
      const visitorsData = {
        US: 398, // USA
        SA: 400, // Saudi Arabia
        CA: 1000, // Canada
        DE: 500, // Germany
        FR: 760, // France
        CN: 300, // China
        AU: 700, // Australia
        BR: 600, // Brazil
        IN: 800, // India
        GB: 320, // Great Britain
        RU: 3000, // Russia
      };

      // World map by jsVectorMap
      const map = new jsVectorMap({
        selector: '#world-map',
        map: 'world',
      });

      // Sparkline charts
      const option_sparkline1 = {
        series: [
          {
            data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
          },
        ],
        chart: {
          type: 'area',
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        stroke: {
          curve: 'straight',
        },
        fill: {
          opacity: 0.3,
        },
        yaxis: {
          min: 0,
        },
        colors: ['#DCE6EC'],
      };

      const sparkline1 = new ApexCharts(document.querySelector('#sparkline-1'), option_sparkline1);
      sparkline1.render();

      const option_sparkline2 = {
        series: [
          {
            data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
          },
        ],
        chart: {
          type: 'area',
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        stroke: {
          curve: 'straight',
        },
        fill: {
          opacity: 0.3,
        },
        yaxis: {
          min: 0,
        },
        colors: ['#DCE6EC'],
      };

      const sparkline2 = new ApexCharts(document.querySelector('#sparkline-2'), option_sparkline2);
      sparkline2.render();

      const option_sparkline3 = {
        series: [
          {
            data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
          },
        ],
        chart: {
          type: 'area',
          height: 50,
          sparkline: {
            enabled: true,
          },
        },
        stroke: {
          curve: 'straight',
        },
        fill: {
          opacity: 0.3,
        },
        yaxis: {
          min: 0,
        },
        colors: ['#DCE6EC'],
      };

      const sparkline3 = new ApexCharts(document.querySelector('#sparkline-3'), option_sparkline3);
      sparkline3.render();
    </script>
    <!--end::Script-->
    @yield('scritps_end_body')
  </body>
  <!--end::Body-->
</html>
