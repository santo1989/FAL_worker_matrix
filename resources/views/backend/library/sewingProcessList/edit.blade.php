<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Edit List of Sewing Processes Information
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> List of Sewing Processes </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sewingProcessList.index') }}">List of Sewing Processes</a></li>
            <li class="breadcrumb-item active">Edit List of Sewing Processes Information</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <x-backend.layouts.elements.errors />
    <form action="{{ route('sewingProcessList.update', ['sewingProcessList' => $sewingProcessList->id]) }}" method="post"
        enctype="multipart/form-data">
        <div class="pb-3">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="process_type">Process Type</label>
                <select name="process_type" id="process_type" class="form-control" required>
                    <option value="">Select Process Type</option>
                    <option value="normal" {{ $sewingProcessList->process_type == 'normal' ? 'selected' : '' }}>Normal Process</option>
                    <option value="critical" {{ $sewingProcessList->process_type == 'critical' ? 'selected' : '' }}>Critical Process</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="machine_type">Machine Type</label>
                <select name="machine_type" id="machine_type" class="form-control" required>
                    <option value="">Select Machine Type</option>
                    <option value="LSM" {{ $sewingProcessList->machine_type == 'LSM' ? 'selected' : '' }}>LOCK STITCH MACHINE</option>
                    <option value="FLM" {{ $sewingProcessList->machine_type == 'FLM' ? 'selected' : '' }}>FLAT LOCK MACHINE</option>
                    <option value="OLM" {{ $sewingProcessList->machine_type == 'OLM' ? 'selected' : '' }}>OVER LOCK MACHINE</option>
                    <option value="NM" {{ $sewingProcessList->machine_type == 'NM' ? 'selected' : '' }}>NORMAL MACHINES</option>
                    <option value="SM" {{ $sewingProcessList->machine_type == 'SM' ? 'selected' : '' }}>SPECIAL MACHINES</option>
                </select>
            </div>
            <br>
            <br>
            <div class="form-group">
                <label for="process_name">List of Sewing Processes Name</label>
                <input type="text" name="process_name" id="process_name" class="form-control" value="{{ $sewingProcessList->process_name }}" required>
            </div>
            <br>
<a type="button" class="btn btn-lg btn-outline-info" href="{{ route('sewingProcessList.index') }}">Cancel</a>
            <x-backend.form.saveButton>Save</x-backend.form.saveButton>
        </div>
    </form>


</x-backend.layouts.master>
