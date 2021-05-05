
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../home/index">
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

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalogos" aria-expanded="true" aria-controls="collapseCatalogos">
        <i class="fas fa-fw fa-cog"></i>
        <span>Catalogos</span>
    </a>
    <div id="collapseCatalogos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Acciones:</h6>
            <a class="collapse-item" href="../Catalogos/registros">Registrar</a>
            <a class="collapse-item" href="../Catalogos/modificar">Modificar</a>
            <a class="collapse-item" href="../Catalogos/consultas">Consultar</a>
        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTrouble" aria-expanded="true" aria-controls="collapseTrouble">
        <i class="fas fa-fw fa-wrench"></i>
        <span>DAC ToubleShooting</span>
    </a>
    <div id="collapseTrouble" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Acciones:</h6>
            <a class="collapse-item" href="../TroubleShooting/registros">Registrar</a>
            <a class="collapse-item" href="../TroubleShooting/consultas">Consultar</a>
        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReporte" aria-expanded="true" aria-controls="collapseReporte">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Reportes</span>
    </a>
    <div id="collapseReporte" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Acciones:</h6>
            <a class="collapse-item" href="../Reporte/reporte_general">Reporte de fallas</a>
            <!-- <a class="collapse-item" href="../Reporte/reporte_fallas">Reporteee</a> -->
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar-->
