<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Edit Data
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> User Data </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sewingProcessList.index') }}">User Data</a></li>
            <li class="breadcrumb-item active">Edit Data</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <x-backend.layouts.elements.errors />
    <form action="{{ route('workerEntries_Line_Entry_store', ['workerEntry' => $workerEntry->id]) }}" method="post"
        enctype="multipart/form-data">
        <div class="pb-3">
            @csrf
            @method('put')
            <div class="row pb-3">
                @csrf

                <div class="form-group col-md-6 col-sm-12">
                    <label for="employee_name_english">Name</label>
                    <input type="text" name="employee_name_english" id="employee_name_english" class="form-control"
                        required placeholder="Enter Full Name" value="{{ $workerEntry->employee_name_english ?? '' }}"
                        readonly>
                </div>

                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="id_card_no">Card No</label>
                    <input type="number" name="id_card_no" id="id_card_no" class="form-control" required
                        placeholder="Enter Card No" value="{{ $workerEntry->id_card_no ?? '' }}">
                </div>
                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="joining_date">Join Date</label>
                    <input type="date" name="joining_date" id="joining_date" class="form-control" required
                        placeholder="Enter Join Date" value="{{ $workerEntry->joining_date ?? '' }}">
                </div>
                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="present_grade">Present Grade</label>
                    <select name="present_grade" id="present_grade" class="form-control" required readonly>
                        <option value="">Select Grade</option>
                        <option value="D" {{ $workerEntry->present_grade == 'D' ? 'selected' : '' }}>D</option>
                        <option value="C" {{ $workerEntry->present_grade == 'C' ? 'selected' : '' }}>C</option>
                        <option value="C+" {{ $workerEntry->present_grade == 'C+' ? 'selected' : '' }}>C+</option>
                        <option value="C++" {{ $workerEntry->present_grade == 'C++' ? 'selected' : '' }}>C++</option>
                        <option value="B" {{ $workerEntry->present_grade == 'B' ? 'selected' : '' }}>B</option>
                        <option value="B+" {{ $workerEntry->present_grade == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="A" {{ $workerEntry->present_grade == 'A' ? 'selected' : '' }}>A</option>
                        <option value="A+" {{ $workerEntry->present_grade == 'A+' ? 'selected' : '' }}>A+</option>
                    </select>

                </div>
                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="designation_name">Designation</label>
                    <select name="designation_name" id="designation_name" class="form-control" required>
                        <option value="">Select Designation</option>
                        <option value="Line Leader"
                            {{ $workerEntry->designation_name == 'Line Leader' ? 'selected' : '' }}>
                            Line Leader</option>
                        <option value="JSMO" {{ $workerEntry->designation_name == 'JSMO' ? 'selected' : '' }}>JSMO
                        </option>
                        <option value="OSMO" {{ $workerEntry->designation_name == 'OSMO' ? 'selected' : '' }}>OSMO
                        </option>
                        <option value="SMO" {{ $workerEntry->designation_name == 'SMO' ? 'selected' : '' }}>SMO
                        </option>
                        <option value="SSMO" {{ $workerEntry->designation_name == 'SSMO' ? 'selected' : '' }}>SSMO
                        </option>
                    </select>

                </div>

                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="salary">Salary</label>
                    <input type="text" name="salary" id="salary" class="form-control" placeholder="Enter Salary"
                        value="{{ $workerEntry->salary ?? '' }}" readonly>
                </div>
                <br>
                <!-- line -->
                <div class="form-group col-md-6 col-sm-12">
                    <label for="line">Line</label>
                    <input type="text" name="line" id="line" class="form-control" required
                        placeholder="Enter Line" value="{{ $workerEntry->line ?? '' }}">
                </div>
                <br>
                <!--floor-->
                <div class="form-group col-md-6 col-sm-12">
                    <label for="floor">Floor</label>
                    <select name="floor" id="floor" class="form-control" required>
                        <option value="">Select Floor</option>
                        <option value="1st Floor" {{ $workerEntry->floor == '1st Floor' ? 'selected' : '' }}>1st Floor
                        </option>
                        <option value="2nd Floor" {{ $workerEntry->floor == '2nd Floor' ? 'selected' : '' }}>2nd Floor
                        </option>
                        <option value="3rd Floor" {{ $workerEntry->floor == '3rd Floor' ? 'selected' : '' }}>3rd Floor
                        </option>
                        <option value="4th Floor" {{ $workerEntry->floor == '4th Floor' ? 'selected' : '' }}>4th Floor
                        </option>
                        <option value="5th Floor" {{ $workerEntry->floor == '5th Floor' ? 'selected' : '' }}>5th Floor
                        </option>
                    </select>

                </div>


            </div>
            <input type="hidden" name="division_id" value="{{ Auth::user()->division_id }}">
            <input type="hidden" name="division_name" value="{{ Auth::user()->division->name }}">
            <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">
            <input type="hidden" name="company_name" value="{{ Auth::user()->company->name }}">
            <input type="hidden" name="department_id" value="{{ Auth::user()->department_id }}">
            <input type="hidden" name="department_name" value="{{ Auth::user()->department->name }}">
            <input type="hidden" name="nid" value="{{ $workerEntry->id_card_no ?? '' }}">

            <br>
            <a type="button" class="btn btn-lg btn-outline-info" id="cancelbutton"
                href="{{ route('workerEntries.index') }}">Cancel</a>
            <x-backend.form.saveButton id="savebutton">Save</x-backend.form.saveButton>
        </div>
    </form>
    <script>
        //if click save button then hide the save button and cancel button 
        document.getElementById('savebutton').addEventListener('click', function(e) {
            document.getElementById('savebutton').style.display = 'none';
            document.getElementById('cancelbutton').style.display = 'none';
        });
    </script>

</x-backend.layouts.master>
