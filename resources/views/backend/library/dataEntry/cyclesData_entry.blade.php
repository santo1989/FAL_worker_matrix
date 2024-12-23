<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Operator Assessment Sheet-3
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Operator Assessment Sheet-Cycles Entry </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('workerEntries.index') }}">Operator Assessment Sheet-3</a>
            </li>
            <li class="breadcrumb-item active">Operator Assessment Sheet-3</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <x-backend.layouts.elements.errors />

    <div class="pb-3">
        @csrf
        <table class="table table-bordered  table-hover">
            <thead>
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Operation Type</th>
                    <th scope="col"> Machine Type</th>
                    <th scope="col">Operation Name</th>
                    <th scope="col">Cycles</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($operationEntry as $oe)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ strtoupper($oe->sewing_process_type) }}</td>
                        <td>
                           
                             
                            @php
                                $machineType = App\Models\SewingProcessList::where('id', $oe->sewing_process_list_id)->first();
                                    // dd($machineType);
                            @endphp

                            {{ $machineType->machine_type }} 
                            {{-- @if ($machineType->machine_type == 'LSM')
                                LOCK STITCH MACHINE
                            @elseif ($machineType->machine_type == 'FLM')
                                FLAT LOCK MACHINE
                            @elseif ($machineType->machine_type == 'OLM')
                                OVER LOCK MACHINE
                            @elseif ($machineType->machine_type == 'NM')
                                NORMAL MACHINES
                            @else
                                SPECIAL MACHINES
                            @endif --}}
                        </td>
                        <td> {{ ucwords($oe->sewing_process_name) }}</td>

                        <td>
                            @if ($oe->sewing_process_avg_cycles == null)
                                @php
                                    $modalId = $oe->id;
                                @endphp
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-outline-dark modal-trigger"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $oe->id }}"
                                    data-modal-id="{{ $oe->id }}"
                                    data-operation-type="{{ $oe->sewing_process_type }}"
                                    data-operation-name="{{ $oe->sewing_process_name }}">
                                    Cycle Entry
                                </button>
                            @else
                                <input type="text" name="cycles[]"
                                    value="{{ number_format($oe->sewing_process_avg_cycles, 2) }}"
                                    class="form-control cycles-input" readonly>
                            @endif
                        </td>

                        <input type="hidden" name="worker_id" value="{{ $oe->worker_id }}">
                        <input type="hidden" name="operation_id[]" value="{{ $oe->id }}">
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>


    <a type="button" class="btn btn-lg btn-outline-info" href="{{ route('workerEntries.index') }}">Cancel</a>
    <a type="button" class="btn btn-lg btn-outline-success"
        href="{{ route('workerEntrys_matrixData_entry_form', $workerEntry_id) }}">Next</a>

    @foreach ($operationEntry as $oe)
        <div class="modal fade" id="staticBackdrop{{ $oe->id }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <form action="{{ route('cyclesData_store', $oe->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="modal_id" value="{{ $oe->id }}">
                        <input type="hidden" name="table_data" id="tableData{{ $oe->id }}" value="">

                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">
                                {{ strtoupper($oe->sewing_process_type) }}, {{ $oe->sewing_process_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <input type="hidden" name="operation_type" value="{{ $oe->sewing_process_type }}">
                            <input type="hidden" name="operation_name" value="{{ $oe->sewing_process_name }}"> <br>
                            <div class="container" style="display: flex; flex-direction: column; align-items: center;">
                                <div class="clock-container" id="clockContainer"
                                    style="display: flex; justify-content: center; align-items: center; height: 200px; width: 200px; border: 3px solid #E9B824; border-radius: 50%; font-size: 24px;">
                                    <div class="clock"
                                        style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%; border-radius: 50%; background-color: #fff; color: #f20d0d;">
                                        00:00:00
                                        {{-- 00:00:000 --}}
                                    </div>
                                </div>
                                <div class="btn-group pt-1 pb-2" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-lg btn-outline-info startBtn"><i
                                            class="bi bi-play-btn"></i> Start</button>
                                    <button type="button" class="btn btn-lg btn-outline-danger stopBtn"><i
                                            class="bi bi-sign-stop-fill"></i> Stop</button>
                                    <button type="button" class="btn btn-lg btn-outline-success saveBtn"><i
                                            class="bi bi-save"></i> Save</button>
                                    <button type="button" class="btn btn-lg btn-outline-danger resetBtn"><i
                                            class="bi bi-arrow-clockwise"></i> Reset</button>
                                </div>
                            </div>
                            <div>
                                <table class="table table-bordered table-hover pt-1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Operation Type</th>
                                            <th>Operation Name</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tableBody"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveButton{{ $oe->id }}"
                                class="btn btn-sm btn-outline-primary ModalsaveBtn"
                                data-modal-id="{{ $oe->id }}"
                                data-form-action="{{ route('cyclesData_store', $oe->id) }}">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach






    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <script>
        // JavaScript code here
        const modals = document.querySelectorAll('.modal');
        const modalTriggers = document.querySelectorAll('.modal-trigger');

        // Add event listeners for each modal
        modalTriggers.forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const modalId = trigger.getAttribute('data-modal-id');
                const operationType = trigger.getAttribute('data-operation-type');
                const operationName = trigger.getAttribute('data-operation-name');
                const startBtn = document.querySelector(`#staticBackdrop${modalId} .startBtn`);
                const stopBtn = document.querySelector(`#staticBackdrop${modalId} .stopBtn`);
                const saveBtn = document.querySelector(`#staticBackdrop${modalId} .saveBtn`);
                const resetBtn = document.querySelector(`#staticBackdrop${modalId} .resetBtn`);
                const tableBody = document.querySelector(`#staticBackdrop${modalId} .tableBody`);
                const display = document.querySelector(`#staticBackdrop${modalId} .clock`);

                let startTime = 0;
                let endTime = 0;
                let interval;
                let savedRecords = [];

                // Function to update the clock display
                function updateClock() {
                    const currentTime = Date.now();
                    const duration = calculateDuration(startTime, currentTime);
                    display.textContent = formatTime(duration);
                }

                // Start button click event
                startBtn.addEventListener('click', () => {
                    startTime = Date.now() - (endTime - startTime); // Resume from where we left off
                    interval = setInterval(updateClock, 1000);
                    startBtn.disabled = true;
                    stopBtn.disabled = false;
                    saveBtn.disabled = true;
                    resetBtn.disabled = true;
                });

                // Stop button click event
                stopBtn.addEventListener('click', () => {
                    endTime = Date.now();
                    clearInterval(interval);
                    startBtn.disabled = true;
                    stopBtn.disabled = true;
                    saveBtn.disabled = false;
                    resetBtn.disabled = false;
                });

                // Save button click event
                saveBtn.addEventListener('click', () => {
                    const duration = calculateDuration(startTime, endTime);
                    savedRecords.push({
                        startTime,
                        endTime,
                        duration
                    });
                    updateTable(modalId, operationType, operationName);
                });

                // Reset button click event
                resetBtn.addEventListener('click', () => {
                    clearInterval(interval);
                    startTime = 0;
                    endTime = 0;
                    display.textContent = '00:00:00'; // Reset the display
                    startBtn.disabled = false;
                    stopBtn.disabled = true;
                    saveBtn.disabled = true;
                    resetBtn.disabled = true;
                });

                // Function to calculate duration in seconds
                function calculateDuration(start, end) {
                    return Math.floor((end - start) / 1000);
                }

                // Function to format time in HH:MM:SS format
                function formatTime(seconds) {
                    const hours = Math.floor(seconds / 3600);
                    const minutes = Math.floor((seconds % 3600) / 60);
                    const remainingSeconds = seconds % 60;
                    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
                }

                // Function to update the table
                function updateTable(modalId, operationType, operationName) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${modalId}</td>
                <td>${operationType}</td>
                <td>${operationName}</td>
                <td>${new Date(startTime).toLocaleString()}</td>
                <td>${new Date(endTime).toLocaleString()}</td>
                <td>${formatTime(calculateDuration(startTime, endTime))}</td>
            `;
                    tableBody.appendChild(row);
                }
            });
        });

        // JavaScript code here
        const ModalsaveBtn = document.querySelectorAll('.ModalsaveBtn');

        // Add event listeners for each "Save" button
        ModalsaveBtn.forEach((ModalsaveBtn) => {
            ModalsaveBtn.addEventListener('click', () => {
                const modalId = ModalsaveBtn.getAttribute('data-modal-id');
                const tableData = getTableData(modalId);

                // Update the hidden field with the table data
                document.getElementById(`tableData${modalId}`).value = JSON.stringify(tableData);

                // Find the corresponding form using data-form-action attribute
                const formAction = ModalsaveBtn.getAttribute('data-form-action');
                const form = document.querySelector(`form[action="${formAction}"]`);

                if (form) {
                    form.submit();
                } else {
                    console.error(`Form not found with action: ${formAction}`);
                }
            });
        });

        // Function to get the table data from the corresponding modal
        function getTableData(modalId) {
            const tableBody = document.querySelector(`#staticBackdrop${modalId} .tableBody`);
            const rows = tableBody.querySelectorAll('tr');
            const tableData = [];

            rows.forEach((row) => {
                const cells = row.querySelectorAll('td');
                const rowData = {
                    sl: cells[0].textContent,
                    operationType: cells[1].textContent,
                    operationName: cells[2].textContent,
                    startTime: cells[3].textContent,
                    endTime: cells[4].textContent,
                    duration: cells[5].textContent,
                };
                tableData.push(rowData);
            });

            return tableData;
        }
    </script> --}}


    <script>
        $(document).ready(function() {
            // Attach an input event listener to each SMV input field
            $('.smv-input').on('input', function() {
                // Get the SMV value entered by the user
                var smv = parseFloat($(this).val());

                // Check if smv is a valid number
                if (!isNaN(smv) && smv > 0) {
                    // Calculate the target value based on SMV
                    var target = 60 / smv;

                    // Round the target value using floor or ceiling
                    var roundedTarget = (target % 1 >= 0.5) ? Math.ceil(target) : Math.floor(target);

                    // Update the corresponding target input field
                    $(this).closest('tr').find('.target-input').val(roundedTarget);
                } else {
                    // If the input is invalid, clear the target input field
                    $(this).closest('tr').find('.target-input').val('');
                }
            });
        });
    </script>

    <script>
        // JavaScript code here
        const modals = document.querySelectorAll('.modal');
        const modalTriggers = document.querySelectorAll('.modal-trigger');

        // Arrays to store records for different rejectDataStatus values
        let savedRecordsStatus0 = [];
        let savedRecordsStatus1 = [];

        // Add event listeners for each modal
        modalTriggers.forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const modalId = trigger.getAttribute('data-modal-id');
                const operationType = trigger.getAttribute('data-operation-type');
                const operationName = trigger.getAttribute('data-operation-name');
                const startBtn = document.querySelector(`#staticBackdrop${modalId} .startBtn`);
                const stopBtn = document.querySelector(`#staticBackdrop${modalId} .stopBtn`);
                const saveBtn = document.querySelector(`#staticBackdrop${modalId} .saveBtn`);
                const resetBtn = document.querySelector(`#staticBackdrop${modalId} .resetBtn`);
                const tableBody = document.querySelector(`#staticBackdrop${modalId} .tableBody`);
                const display = document.querySelector(`#staticBackdrop${modalId} .clock`);

                const clockContainer = document.querySelector(`#staticBackdrop${modalId} .clock-container`);

                let startTime = 0;
                let endTime = 0;
                let interval;

                // Function to update the clock display
                function updateClock() {
                    const currentTime = Date.now();
                    // const duration = calculateDuration(startTime, currentTime);
                    const duration1 = currentTime - startTime;
                    display.textContent = formatTime(duration1);
                    const duration = calculateDuration(startTime, currentTime);

                }

                startBtn.disabled = false;
                stopBtn.disabled = true;
                saveBtn.disabled = true;
                resetBtn.disabled = true;

                // Start button click event
                startBtn.addEventListener('click', () => {
                    startTime = Date.now() - (endTime - startTime); // Resume from where we left off
                    // interval = setInterval(updateClock, 1000);
                    interval = setInterval(updateClock, 1);
                    startBtn.disabled = true;
                    stopBtn.disabled = false;
                    saveBtn.disabled = true;
                    resetBtn.disabled = true;
                    clockContainer.style.border = '10px solid #EE9322';
                });

                // Stop button click event
                stopBtn.addEventListener('click', () => {
                    endTime = Date.now();
                    clearInterval(interval);
                    startBtn.disabled = true;
                    stopBtn.disabled = true;
                    saveBtn.disabled = false;
                    resetBtn.disabled = false;
                    clockContainer.style.border = '15px solid #D83F31';
                });

                // Save button click event
                saveBtn.addEventListener('click', () => {
                    const duration = calculateDuration(startTime, endTime);
                    const record = {
                        startTime,
                        endTime,
                        duration,
                        rejectDataStatus: 0, // Default value for normal records
                    };
                    savedRecordsStatus0.push(record);

                    updateTable(modalId, operationType, operationName, record);
                    clearInterval(interval);
                    resetFields();
                });

                // Reset button click event
                resetBtn.addEventListener('click', () => {
                    // Save the record with rejectDataStatus=1 to the rejectDataTable
                    const duration = calculateDuration(startTime, endTime);
                    const record = {
                        startTime,
                        endTime,
                        duration,
                        rejectDataStatus: 1, // Set rejectDataStatus to 1 for rejected records
                    };
                    savedRecordsStatus1.push(record);
                    updateTable(modalId, operationType, operationName, record);
                    clearInterval(interval);
                    resetFields();
                });

                // Function to reset fields
                function resetFields() {
                    startTime = 0;
                    endTime = 0;
                    display.textContent = '00:00:00'; // Reset the display
                    // display.textContent = '00:00:000'; // Reset the display
                    startBtn.disabled = false;
                    stopBtn.disabled = true;
                    saveBtn.disabled = true;
                    resetBtn.disabled = true;
                    clockContainer.style.border = '3px solid #E9B824';
                }

                // Function to calculate duration in seconds
                function calculateDuration(start, end) {
                    return Math.floor((end - start) / 1000);
                }

                // Function to format time in HH:MM:SS format
                function formatTime(milliseconds) {
                    // const hours = Math.floor(seconds / 3600);
                    // const minutes = Math.floor((seconds % 3600) / 60);
                    // const remainingSeconds = seconds % 60;
                    // return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`; 

                    const minutes = Math.floor((milliseconds / 1000 / 60) % 60);
                    const seconds = Math.floor((milliseconds / 1000) % 60);
                    const miliSeconds = Math.floor(milliseconds % 1000);
                    return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(miliSeconds).padStart(3, '0')}`;
                }

                // Function to format time in HH:MM:SS format
                function formatTimeCalculate(seconds) {
                    const hours = Math.floor(seconds / 3600);
                    const minutes = Math.floor((seconds % 3600) / 60);
                    const remainingSeconds = seconds % 60;
                    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
                }

                // Function to update the table
                function updateTable(modalId, operationType, operationName, record) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
        <td style="display: ${record.rejectDataStatus === 1 ? 'none' : 'table-cell'}">${modalId}</td>
        <td style="display: ${record.rejectDataStatus === 1 ? 'none' : 'table-cell'}">${operationType}</td>
        <td style="display: ${record.rejectDataStatus === 1 ? 'none' : 'table-cell'}">${operationName}</td>
        <td style="display: ${record.rejectDataStatus === 1 ? 'none' : 'table-cell'}">${new Date(record.startTime).toLocaleString()}</td>
        <td style="display: ${record.rejectDataStatus === 1 ? 'none' : 'table-cell'}">${new Date(record.endTime).toLocaleString()}</td>
        <td style="display: ${record.rejectDataStatus === 1 ? 'none' : 'table-cell'}">${formatTimeCalculate(record.duration)}</td>
        <td style="display: none;">${record.rejectDataStatus}</td>
    `;
                    tableBody.appendChild(row);

                }



            });
        });

        // JavaScript code here
        const ModalsaveBtn = document.querySelectorAll('.ModalsaveBtn');

        // Add event listeners for each "Save" button
        ModalsaveBtn.forEach((ModalsaveBtn) => {
            ModalsaveBtn.addEventListener('click', () => {
                const modalId = ModalsaveBtn.getAttribute('data-modal-id');
                const combinedTableData = [...savedRecordsStatus0, ...savedRecordsStatus1];

                // Update the hidden field with the table data
                document.getElementById(`tableData${modalId}`).value = JSON.stringify(combinedTableData);

                // Find the corresponding form using data-form-action attribute
                const formAction = ModalsaveBtn.getAttribute('data-form-action');
                const form = document.querySelector(`form[action="${formAction}"]`);

                if (form) {
                    form.submit();
                } else {
                    console.error(`Form not found with action: ${formAction}`);
                }
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            // Function to check if the table body is empty and hide/show the "Save" button
            function checkTableBody() {
                $('.tableBody').each(function() {
                    const modalId = $(this).closest('.modal').attr('id').replace('staticBackdrop', '');
                    const saveButton = $(`#saveButton${modalId}`);

                    if ($(this).is(':empty')) {
                        saveButton.hide();
                    } else {
                        saveButton.show();
                    }
                });
            }

            // Call the function when the page loads
            checkTableBody();

            // Add an event listener to the table body to check when it changes
            $('.tableBody').on('DOMSubtreeModified', function() {
                checkTableBody();
            });
        });
    </script> --}}
    
</x-backend.layouts.master>
