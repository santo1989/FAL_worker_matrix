<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Create List of Sewing Processes
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> List of Sewing Processes </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sewingProcessList.index') }}">List of Sewing Processes</a></li>
            <li class="breadcrumb-item active">Create List of Sewing Processes</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <x-backend.layouts.elements.errors />
    <form action="{{ route('sewingProcessList.store') }}" method="post" enctype="multipart/form-data">
        <div class="pb-3">
            @csrf

            <div class="form-group">
                <label for="process_type">Process Type</label>
                <select name="process_type" id="process_type" class="form-control" required>
                    <option value="">Select Process Type</option>
                    <option value="normal">Normal Process</option>
                    <option value="semi-critical">Semi-Critical Process</option>
                    <option value="critical">Critical Process</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="machine_type">Machine Type</label>
                <select name="machine_type" id="machine_type" class="form-control" required>
                    <option value="">Select Machine Type</option>
                    <option value="OL">OVER LOCK MACHINE</option>
                    <option value="F/L">FLAT LOCK MACHINE</option>
                    <option value="SND">Single Needle Lock Stitch</option>
                    <option value="DNL">Double Needle Lock Stitch Machine</option>
                    <option value="KNS">Kanchai Machine</option>
                    <option value="LSM">LOCK STITCH MACHINE</option>
                    <option value="BS">Button Stitch Machine</option>
                    <option value="BH">Button Hole Machine</option>
                    <option value="BTK">Bartack Machine</option>
                    
                    <option value="F/L/KNS">Multi Needle Chain Stitch Machine/ Kanchai Machine</option>
                    <option value="SM">SPECIAL MACHINES</option>
                </select>
            </div>
            <br>

            <div class="form-group col-md-10">
                <label for="process_name">List of Sewing Processes Name</label>
                <div id="process-inputs">
                    <div class="process-input p-1" style="display: flex;">
                        <input type="text" name="process_name[]" class="form-control mr-2" style="flex-grow: 1;"
                            required placeholder="Process Name" required>
                        <input type="number" name="smv[]" class="form-control mr-2" style="flex-grow: 1;"
                            placeholder="SMV" step="0.01" min="0" required>
                        <input type="number" name="standard_capacity[]" class="form-control mr-2" style="flex-grow: 1;"
                            placeholder="Standard Capacity" required>
                        <input type="number" name="standard_time_sec[]" class="form-control mr-2" style="flex-grow: 1;"
                            placeholder="Standard Time (sec)" required>
                        <a type="button" class="btn btn-outline-danger remove-process-input">Remove</a>
                    </div>
                </div>
                <a type="button" id="add-process-input" class="btn btn-outline-success">Add Processes</a>
            </div>
            <br>
            <a type="button" class="btn btn-lg btn-outline-info" href="{{ route('sewingProcessList.index') }}">Cancel</a>
            <x-backend.form.saveButton>Save</x-backend.form.saveButton>
        </div>
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add Process input field
            $('#add-process-input').click(function() {
                $('#process-inputs').append(
                    '<div class="process-input p-1" style="display: flex;"><input type="text" name="process_name[]" class="form-control mr-2" style="flex-grow: 1;" required placeholder="Process Name"> <input type="number" name="smv[]" class="form-control mr-2" style="flex-grow: 1;" placeholder="SMV" step="0.01" min="0" required> <input type="number" name="standard_capacity[]" class="form-control mr-2" style="flex-grow: 1;" placeholder="standard capacity" required><input type="number" name="standard_time_sec[]" class="form-control mr-2" style="flex-grow: 1;" placeholder="standard time (sec)" required><a type="button" class="btn btn-outline-danger remove-process-input">Remove</a></div>'
                );
            });

            // Remove Process input field
            $('#process-inputs').on('click', '.remove-process-input', function() {
                $(this).parent().remove();
            });
        });
    </script>
</x-backend.layouts.master>
