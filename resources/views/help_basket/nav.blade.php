<ul class="nav nav-tabs mb-3 d-print-none">
    

    <li class="nav-item">
        <a class="nav-link" href="{{ route('help_basket.georeferencing')  }}">
            <i class="fas fa-globe"></i> Georreferencia
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('help_basket.excel')  }}">
            <i class="fas fa-file-excel"></i> Reporte Canastas
        </a>
    </li>

    @can('Basket: admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('help_basket.excelall')  }}">
            <i class="fas fa-file-excel"></i> Reporte Consolidado
        </a>
    </li>
    @endcan
</ul>