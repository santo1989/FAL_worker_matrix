<x-backend.layouts.master>
    <div class="m-5">
        <h3>Welcome,
            @php
                echo auth()->user()->name;
            @endphp !
        </h3>
    </div>
    <div class="container">
        <div class="row-justify-content-center">
            <a class="btn btn-outline-success btn-lg" href="{{ route('workerEntries.create') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                Assessment Sheet Entry Form
            </a>

            <a class="btn btn-outline-success btn-lg" href="{{ route('workerEntries.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                Operator Assessment Sheet Management
            </a>




        </div>
    </div>
    <div class="container">
        @include('report.dashboard_graph')
    </div>
</x-backend.layouts.master>
