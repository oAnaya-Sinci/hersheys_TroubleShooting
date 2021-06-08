
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ config('app.url', '') }}">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">{{ config('app.name', 'hersheys') }}</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>

@if($adminUser)

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalogos" aria-expanded="true" aria-controls="collapseCatalogos">
            <i class="fas fa-fw far fa-edit"></i>
            <span>Catalogos</span>
        </a>
        <div id="collapseCatalogos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="{{ config('app.url', '') }}Catalogos/registros">Registrar</a>
                <a class="collapse-item" href="{{ config('app.url', '') }}Catalogos/modificar">Modificar</a>
                <a class="collapse-item" href="{{ config('app.url', '') }}Catalogos/consultas">Consultar</a>
            </div>
        </div>
    </li>
@endif

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTrouble" aria-expanded="true" aria-controls="collapseTrouble">
        <i class="fas fa-fw fas fa-file-alt"></i>
        <span>DAC ToubleShooting</span>
    </a>
    <div id="collapseTrouble" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item" href="{{ config('app.url', '') }}TroubleShooting/registros">Registrar</a>
            <a class="collapse-item" href="{{ config('app.url', '') }}TroubleShooting/consultas">Consultar</a>
        </div>
    </div>
</li>

@if($adminUser)

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReporte" aria-expanded="true" aria-controls="collapseReporte">
            <i class="fas fa-fw fas fa-chart-line"></i>
            <span>Reportes</span>
        </a>
        <div id="collapseReporte" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="{{ config('app.url', '') }}Reporte/reporte_general">Reporte de fallas</a>
                <!-- <a class="collapse-item" href="/Reporte/reporte_fallas">Reporteee</a> -->
            </div>
        </div>
    </li>

    <!-- Nav Item - usuarios menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="true" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fas fa-user"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="{{ config('app.url', '') }}usuarios/consultar">Consultar</a>
            </div>
        </div>
    </li>
@endif

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar-->
