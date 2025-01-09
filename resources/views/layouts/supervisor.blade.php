        <x-backend.layouts.master>

            <x-slot name="pageTitle">
                Dashboard
            </x-slot>

            <x-slot name='breadCrumb'>
                <x-backend.layouts.elements.breadcrumb>
                    <x-slot name="pageHeader"> Dashboard </x-slot>
                    <li class="breadcrumb-item active">Dashboard</li>
                </x-backend.layouts.elements.breadcrumb>
            </x-slot>

            <div class="container">
                <div class="row-justify-content-center">
                    <a class="btn btn-outline-success btn-lg" href="{{ route('workerEntries.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                        Operator Assessment Sheet Management
                    </a>

                </div>
             
                @include('report.dashboard_graph')
            </div>
        </x-backend.layouts.master>
