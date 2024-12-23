<x-backend.layouts.master>
    <x-slot name="pageTitle">
        List of Sewing Processes Inforomation
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> List of Sewing Processes </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sewingProcessList.index') }}">List of Sewing Processes</a></li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <section class="content">
        <div class="container-fluid">

            @if (session('message'))
                <div class="alert alert-success">
                    <span class="close" data-dismiss="alert">&times;</span>
                    <strong>{{ session('message') }}.</strong>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- kpi Table goes here --}}
                            <table class="table table-bordered">
                                <tr class="form-group">
                                    <th for="process_type">Process Type: </th>
                                    @if ($sewingProcessList->process_type == 'normal')
                                        <td> Normal Process</td>
                                    @elseif($sewingProcessList->process_type == 'critical')
                                        <td> Critical Process</td>
                                    @endif
                                </tr>
                                <tr class="form-group">
                                    <th for="machine_type">Machine Type: </th>
                                    {{-- @if ($sewingProcessList->machine_type == 'LSM')
                                        <td>LOCK STITCH MACHINE</td>
                                    @elseif($sewingProcessList->machine_type == 'FLM')
                                        <td>FLAT LOCK MACHINE</td>
                                    @elseif($sewingProcessList->machine_type == 'OLM')
                                        <td>OVER LOCK MACHINE</td>
                                    @elseif($sewingProcessList->machine_type == 'NM')
                                        <td>NORMAL MACHINES</td>
                                    @elseif($sewingProcessList->machine_type == 'SM')
                                        <td>SPECIAL MACHINES</td>
                                    @endif --}}
                                    <td>{{ $sewingProcessList->machine_type }}</td>
                                </tr>
                                <tr class="form-group">
                                    <th for="process_name"> Sewing Processes Name: </th>
                                    <td>{{ $sewingProcessList->process_name }}</td>
                                </tr>

                                <tr class="form-group ">
                                    <th for="smv">SMV: </th>
                                    <td>{{ $sewingProcessList->smv }}</td> 

                                </tr>
                                <tr class="form-group ">
                                    <th>Capacity: </th>
                                    <td>{{ $sewingProcessList->standard_capacity }}</td>
                                </tr>
                                <tr class="form-group ">
                                    <th>standard_time_sec: </th>
                                    <td>
                                       {{$sewingProcessList->standard_time_sec}} 
                                    </td>
                                </tr>

                            </table>
                            <a type="button" class="btn btn-lg btn-outline-info"
                                href="{{ route('sewingProcessList.index') }}">Back</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</x-backend.layouts.master>
