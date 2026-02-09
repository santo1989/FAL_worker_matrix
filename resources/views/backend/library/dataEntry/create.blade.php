<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Operator Assessment Sheet-1
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Operator Assessment Sheet-ID Entry </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('workerEntries.index') }}">Operator Assessment Sheet-1</a>
            </li>
            <li class="breadcrumb-item active">Operator Assessment Sheet-1</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <x-backend.layouts.elements.errors />
    <form action="{{ route('workerEntrys_id_search') }}" method="post" enctype="multipart/form-data">
        <div class="pb-3">
            @csrf

            <div class="form-group">
                <label for="id">Card No</label>
                <input type="text" name="id" class="form-control" required placeholder="Enter Card No">
            </div>
            <br>
            <button type="submit" class="btn btn-sm btn-outline-info">Search</button>
            <a type="button" class="btn btn-sm btn-outline-danger" href="{{ route('workerEntries.create') }}"><i
                    class="fas fa-redo"></i>Reset</a>
        </div>
    </form>
    <section class="pb-3">
        <form action="{{ route('workerEntrys_id_entry') }}" method="post" enctype="multipart/form-data">
            <div class="row pb-3">
                @csrf

                <div class="form-group col-md-6 col-sm-12">
                    <label for="floor">Floor</label>
                    <select name="floor" id="floor" class="form-control" required>
                        <option value="">Select Floor</option>
                        <option value="1st Floor" {{ $worker->floor == '1st Floor' ? 'selected' : '' }}>1st Floor
                        </option>
                        <option value="2nd Floor" {{ $worker->floor == '2nd Floor' ? 'selected' : '' }}>2nd Floor
                        </option>
                        <option value="3rd Floor" {{ $worker->floor == '3rd Floor' ? 'selected' : '' }}>3rd Floor
                        </option>
                        <option value="4th Floor" {{ $worker->floor == '4th Floor' ? 'selected' : '' }}>4th Floor
                        </option>
                        <option value="5th Floor" {{ $worker->floor == '5th Floor' ? 'selected' : '' }}>5th Floor
                        </option>
                    </select>

                </div>
                <br>
                <!-- line -->
                <div class="form-group col-md-6 col-sm-12">
                    <label for="line">Line</label>
                    <input type="text" name="line" id="line" class="form-control" required
                        placeholder="Enter Line" value="{{ $worker->line ?? '' }}">
                </div>
                <br>

                <div class="form-group col-md-6 col-sm-12">
                    <label for="examination_date">Date</label>
                    <input type="date" name="examination_date" id="examination_date" class="form-control" required
                        value="{{ $worker->examination_date ?? now()->format('Y-m-d') }}">
                </div>
                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="id_card_no">Card No</label>
                    <input type="number" name="id_card_no" id="id_card_no" class="form-control" required
                        placeholder="Enter Card No" value="{{ $worker->id_card_no ?? '' }}">
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="employee_name_english">Name</label>
                    <input type="text" name="employee_name_english" id="employee_name_english" class="form-control"
                        required placeholder="Enter Full Name" value="{{ $worker->employee_name_english ?? '' }}">
                </div>


                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="joining_date">Join Date</label>
                    <input type="date" name="joining_date" id="joining_date" class="form-control" required
                        placeholder="Enter Join Date" value="{{ $worker->joining_date ?? '' }}">
                </div>
                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="present_grade">Present Grade</label>
                    <select name="present_grade" id="present_grade" class="form-control" required>
                        <option value="">Select Grade</option>
                        <option value="D" {{ $worker->present_grade == 'D' ? 'selected' : '' }}>D</option>
                        <option value="C" {{ $worker->present_grade == 'C' ? 'selected' : '' }}>C</option>
                        <option value="C+" {{ $worker->present_grade == 'C+' ? 'selected' : '' }}>C+</option>
                        <option value="C++" {{ $worker->present_grade == 'C++' ? 'selected' : '' }}>C++</option>
                        <option value="B" {{ $worker->present_grade == 'B' ? 'selected' : '' }}>B</option>
                        <option value="B+" {{ $worker->present_grade == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="A" {{ $worker->present_grade == 'A' ? 'selected' : '' }}>A</option>
                        <option value="A+" {{ $worker->present_grade == 'A+' ? 'selected' : '' }}>A+</option>
                    </select>

                </div>
                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="designation_name">Designation</label>
                    <select name="designation_name" id="designation_name" class="form-control" required>
                        <option value="">Select Designation</option>
                        <option value="Line Leader" {{ $worker->designation_name == 'Line Leader' ? 'selected' : '' }}>
                            Line Leader</option>
                        <option value="JSMO" {{ $worker->designation_name == 'JSMO' ? 'selected' : '' }}>JSMO
                        </option>
                        <option value="OSMO" {{ $worker->designation_name == 'OSMO' ? 'selected' : '' }}>OSMO
                        </option>
                        <option value="SMO" {{ $worker->designation_name == 'SMO' ? 'selected' : '' }}>SMO</option>
                        <option value="SSMO" {{ $worker->designation_name == 'SSMO' ? 'selected' : '' }}>SSMO
                        </option>
                    </select>

                </div>
                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="experience">Experience</label>
                    <input type="text" name="experience" id="experience" class="form-control" readonly required
                        placeholder="Experience" value="{{ $worker->experience ?? '' }}">

                </div>

                <br>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="salary">Salary</label>
                    <input type="text" name="salary" id="salary" class="form-control"
                        placeholder="Enter Salary" value="{{ $worker->salary ?? '' }}">
                </div>
                <br>

                @if (Auth::user()->role && (Auth::user()->role->name == 'HR' || Auth::user()->role->name == 'Admin'))
                    <!-- Father Name -->
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="father_name">Father Name</label>
                        <input type="text" name="father_name" id="father_name" class="form-control"
                            placeholder="Enter Father Name" value="{{ $worker->father_name ?? '' }}">
                    </div>
                    <br>

                    <!-- Husband Name -->
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="husband_name">Husband Name</label>
                        <input type="text" name="husband_name" id="husband_name" class="form-control"
                            placeholder="Enter Husband Name" value="{{ $worker->husband_name ?? '' }}">
                    </div>
                    <br>

                    <!-- Present Address -->
                    <div class="form-group col-md-12 col-sm-12">
                        <label for="present_address">Present Address</label>
                        <textarea name="present_address" id="present_address" class="form-control" rows="3"
                            placeholder="Enter Present Address">{{ $worker->present_address ?? '' }}</textarea>
                    </div>
                    <br>

                    <!-- Permanent Address -->
                    <div class="form-group col-md-12 col-sm-12">
                        <label for="permanent_address">Permanent Address</label>
                        <textarea name="permanent_address" id="permanent_address" class="form-control" rows="3"
                            placeholder="Enter Permanent Address">{{ $worker->permanent_address ?? '' }}</textarea>
                    </div>
                    <br>
                @endif


            </div>
            <input type="hidden" name="division_id" value="{{ Auth::user()->division_id }}">
            <input type="hidden" name="division_name" value="{{ Auth::user()->division->name }}">
            <input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">
            <input type="hidden" name="company_name" value="{{ Auth::user()->company->name }}">
            <input type="hidden" name="department_id" value="{{ Auth::user()->department_id }}">
            <input type="hidden" name="department_name" value="{{ Auth::user()->department->name }}">


            <a type="button" class="btn btn-lg btn-outline-info"
                href="{{ route('workerEntries.index') }}">Cancel</a>
            <x-backend.form.saveButton>Save</x-backend.form.saveButton>

        </form>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <script>
        // Check if the input elements exist
        var joiningDateInput = document.getElementById("joining_date");
        var experienceInput = document.getElementById("experience");

        if (joiningDateInput && experienceInput) {
            // Get the value of the joining date input field and convert it to a Date object
            var joiningDate = new Date(joiningDateInput.value);

            // Get the current date
            var currentDate = new Date();

            // Calculate the difference in milliseconds
            var diff = currentDate - joiningDate;

            // Calculate years, months, and days
            var years = Math.floor(diff / (365.25 * 24 * 60 * 60 * 1000));
            var months = Math.floor((diff % (365.25 * 24 * 60 * 60 * 1000)) / (30.44 * 24 * 60 * 60 * 1000));
            var days = Math.floor((diff % (30.44 * 24 * 60 * 60 * 1000)) / (24 * 60 * 60 * 1000));

            if (isNaN(years) || isNaN(months) || isNaN(days) || days < 0) {
                experienceInput.value = "0 years, 0 months, 0 days";
            } else {
                // Set the experience input value
                experienceInput.value = years + " years, " + months + " months, " + days + " days";
            }
        }
    </script> --}}

    <script>
        // Function to calculate and display experience
        function calculateExperience() {
            // Get the input elements
            var joiningDateInput = document.getElementById("joining_date");
            var experienceInput = document.getElementById("experience");

            // Ensure input elements exist
            if (!joiningDateInput || !experienceInput) return;

            // Get the value of the joining date input field
            var joiningDateValue = joiningDateInput.value;

            if (!joiningDateValue) {
                experienceInput.value = "0 years, 0 months, 0 days";
                return;
            }

            // Convert to Date object
            var joiningDate = new Date(joiningDateValue);
            var currentDate = new Date();

            if (isNaN(joiningDate.getTime())) {
                experienceInput.value = "Invalid date";
                return;
            }

            // Calculate the difference in milliseconds
            var diff = currentDate - joiningDate;

            // Calculate years, months, and days
            var years = Math.floor(diff / (365.25 * 24 * 60 * 60 * 1000));
            var months = Math.floor((diff % (365.25 * 24 * 60 * 60 * 1000)) / (30.44 * 24 * 60 * 60 * 1000));
            var days = Math.floor((diff % (30.44 * 24 * 60 * 60 * 1000)) / (24 * 60 * 60 * 1000));

            if (days < 0) {
                experienceInput.value = "0 years, 0 months, 0 days";
                return;
            }

            // Set the experience input value
            experienceInput.value = years + " years, " + months + " months, " + days + " days";
        }

        // Attach event listener on DOM load
        document.addEventListener("DOMContentLoaded", function() {
            var joiningDateInput = document.getElementById("joining_date");

            if (joiningDateInput) {
                // Calculate experience on input change
                joiningDateInput.addEventListener("input", calculateExperience);

                // Calculate experience if a value is already present
                calculateExperience();
            }
        });
    </script>

</x-backend.layouts.master>
