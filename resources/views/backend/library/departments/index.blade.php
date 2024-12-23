<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Department List
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Department </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Department</a></li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (is_null($departments) || empty($departments))
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                {{-- <a class="btn btn-primary" href={{ route('departments.create') }}>Create</a> --}}
                                <x-backend.form.anchor :href="route('departments.create')" type="create" />

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                {{-- department Table goes here --}}

                                <table id="datatablesSimple" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl#</th>
                                            <th>Company Name</th>
                                            <th>Department Name</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $sl=0 @endphp
                                        @foreach ($departments as $department)
                                            <tr>
                                                <td>{{ ++$sl }}</td>
                                                <td>{{ $department->company->name }}</td>
                                                <td>{{ $department->name }}</td>
                                                <td>
                                                    {{-- <a class="btn btn-primary my-1 mx-1 btn-sm"
                                                        href={{ route('departments.edit', ['department' => $department->id]) }}>Edit</a>
                                                    <a class="btn btn-primary my-1 mx-1 btn-sm"
                                                        href={{ route('departments.show', ['department' => $department->id]) }}>Show</a> --}}
                                                    <x-backend.form.anchor :href="route('departments.edit', [
                                                        'department' => $department->id,
                                                    ])" type="edit" />



                                                    <x-backend.form.anchor :href="route('departments.show', [
                                                        'department' => $department->id,
                                                    ])" type="show" />
                                                    @can('Admin')
                                                        <form style="display:inline"
                                                            action="{{ route('departments.destroy', ['department' => $department->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')

                                                            <button
                                                                onclick="return confirm('Are you sure want to delete ?')"
                                                                class="btn btn-outline-danger my-1 mx-1 btn-sm"
                                                                type="submit"><i class="bi bi-trash"></i> Delete</button>
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


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    @endif
</x-backend.layouts.master>
