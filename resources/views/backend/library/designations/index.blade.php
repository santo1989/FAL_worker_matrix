<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Designation List
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Designation </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('designations.index') }}">Designation</a></li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (is_null($designations) || empty($designations))
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
                                {{-- <a class="btn btn-primary" href={{ route('designations.create') }}>Create</a> --}}
                                <x-backend.form.anchor :href="route('designations.create')" type="create" />
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                {{-- designation Table goes here --}}

                                <table id="datatablesSimple" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl#</th>
                                            <th>Division Name</th>
                                            <th>Name</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $sl=0 @endphp
                                        @foreach ($designations as $designation)
                                            <tr>
                                                <td>{{ ++$sl }}</td>
                                                <td>{{ $designation->division->name }}</td>
                                                <td>{{ $designation->name }}</td>
                                                <td>
                                                    {{-- <a class="btn btn-primary my-1 mx-1 btn-sm"
                                                        href={{ route('designations.edit', ['designation' => $designation->id]) }}>Edit</a>
                                                    <a class="btn btn-primary my-1 mx-1 btn-sm"
                                                        href={{ route('designations.show', ['designation' => $designation->id]) }}>Show</a> --}}
                                                    <x-backend.form.anchor :href="route('designations.edit', [
                                                        'designation' => $designation->id,
                                                    ])" type="edit" />

                                                    <x-backend.form.anchor :href="route('designations.show', [
                                                        'designation' => $designation->id,
                                                    ])" type="show" />
                                                    @can('Admin')
                                                        <form style="display:inline"
                                                            action="{{ route('designations.destroy', ['designation' => $designation->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')

                                                            <button
                                                                onclick="return confirm('Are you sure want to delete ?')"
                                                                class="btn btn-outline-danger  my-1 mx-1 btn-sm"
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
