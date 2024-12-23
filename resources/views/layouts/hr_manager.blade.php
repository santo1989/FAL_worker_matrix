        <x-backend.layouts.master>

            <x-slot name="pageTitle">
                HR Dashboard
            </x-slot>

            <x-slot name='breadCrumb'>
                <x-backend.layouts.elements.breadcrumb>
                    <x-slot name="pageHeader"> HR Dashboard </x-slot>
                    <li class="breadcrumb-item active">HR Dashboard</li>
                </x-backend.layouts.elements.breadcrumb>
            </x-slot>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card" style="width:18rem;">
                            <div class="card-body">
                                <a href="{{ url('training_development') }}"
                                    class="btn btn-outline-primary btn-block">Training & Development</a>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="width:18rem;">
                            <div class="card-body">
                                <a href="{{ url('disciplinary_problems') }}"
                                    class="btn btn-outline-danger btn-block">Disciplinary Problems & Action</a>

                            </div>
                        </div>

                    </div>  
                </div>
            </div>
            @include('report.dashboard_graph')   
               

        </x-backend.layouts.master>
