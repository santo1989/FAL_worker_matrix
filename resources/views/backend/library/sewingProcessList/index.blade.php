<x-backend.layouts.master>
    <x-slot name="pageTitle">
        List of Sewing Processes List
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
            @if (is_null($sewingProcessList) || empty($sewingProcessList))
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <h1 class="text-danger"> <strong>Currently No Information Available!</strong> </h1>
                    </div>
                </div>
            @else
                @if (session('message'))
                    <div class="alert alert-success">
                        <span class="close" data-dismiss="alert">&times;</span>
                        <strong>{{ session('message') }}.</strong>
                    </div>
                @endif

                <div class="container">
                    <div class="card" style="overflow-x: auto; overflow-y: auto;">
                        <div class="card-header">
                            <x-backend.form.anchor :href="route('sewingProcessList.create')" type="create" />
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- spl Table goes here --}}

                            <table id="datatablesSimple" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl#</th>
                                        <th>Process Type</th>
                                        <th>Machine Type</th>
                                        <th>Process Name</th>
                                        <th>SMV</th>
                                        <th>Active</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sl=0 @endphp
                                    @foreach ($sewingProcessList as $spl)
                                        <tr>

                                            <td>{{ ++$sl }}</td>
                                            <td>
                                                @if ($spl->process_type == 'normal')
                                                    <span class="badge badge-primary">Normal Process</span>
                                                @elseif ($spl->process_type == 'semi-critical')
                                                    <span class="badge badge-success">Semi Critical Process</span>
                                               
                                                @else
                                                    <span class="badge badge-danger">Critical Process</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $spl->machine_type }}
                                                {{-- @if ($spl->machine_type == 'LSM')
                                                    <span class="badge badge-secondary">LOCK STITCH MACHINE</span>
                                                @elseif ($spl->machine_type == 'F/L')
                                                    <span class="badge badge-warning">FLAT LOCK MACHINE</span>
                                                @elseif ($spl->machine_type == 'OL')
                                                    <span class="badge badge-info">OVER LOCK MACHINE</span>
                                                @elseif ($spl->machine_type == 'NM')
                                                    <span class="badge badge-success">NORMAL MACHINES</span>
                                                @else
                                                    <span class="badge badge-dark">SPECIAL MACHINES</span>
                                                @endif --}}
                                            </td>
                                            <td>{{ $spl->process_name }}</td>
                                            <td>{{ $spl->smv }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('sewingProcessList.active', ['spl' => $spl->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button
                                                        onclick="return confirm('Are you sure want to change status ?')"
                                                        class="btn btn-sm {{ $spl->is_active ? 'btn-success' : 'btn-danger' }}"
                                                        type="submit">{{ $spl->is_active ? 'Active' : 'Inactive' }}</button>
                                                </form>
                                            </td>
                                            <td>
                                                @can('Admin')
                                                    <x-backend.form.anchor :href="route('sewingProcessList.edit', $spl)" type="edit" />
                                                @endcan
                                                <x-backend.form.anchor :href="route('sewingProcessList.show', $spl)" type="show" />

                                                @can('Admin')
                                                    <form style="display:inline"
                                                        action="{{ route('sewingProcessList.destroy', ['sewingProcessList' => $spl->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')

                                                        <button onclick="return confirm('Are you sure want to delete ?')"
                                                            class="btn btn-outline-danger my-1 mx-1 btn-sm"
                                                            type="submit"><i class="bi bi-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.col -->
                </div>
                <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    @endif

    <script>
        $(function() {
            $("#datatablesSimple").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>

</x-backend.layouts.master>
