<x-backend.layouts.master>
    <x-slot name="pageTitle">Operator Assessment Sheet-3 (Exam)</x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Operator Assessment Sheet-Cycles Entry (Exam) </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Exam Candidates</a></li>
            <li class="breadcrumb-item active">Cycles Entry</li>
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
                    <th scope="col">SMV</th>
                    <th scope="col">Target</th>
                    <th scope="col">Cycle Time</th>
                    <th scope="col">Cycles</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($entries as $oe)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ strtoupper($oe->sewing_process_type) }}</td>
                        <td>
                            @php
                                $machineType = App\Models\SewingProcessList::where(
                                    'id',
                                    $oe->sewing_process_list_id,
                                )->first();
                            @endphp
                            {{ $machineType->machine_type ?? '' }}
                        </td>
                        <td> {{ ucwords($oe->sewing_process_name) }}</td>
                        <td>
                            @php
                                $smv = App\Models\SewingProcessList::where('id', $oe->sewing_process_list_id)
                                    ->pluck('smv')
                                    ->first();
                                $smv = number_format($smv ?? 0, 2);
                            @endphp
                            {{ $smv }}
                        </td>
                        <td>
                            @php
                                $standard_capacity = App\Models\SewingProcessList::where(
                                    'id',
                                    $oe->sewing_process_list_id,
                                )
                                    ->pluck('standard_capacity')
                                    ->first();
                                $target = number_format($standard_capacity ?? 0, 0);
                            @endphp
                            {{ $target }}
                        </td>
                        <td>
                            @php
                                $standard_time_sec = App\Models\SewingProcessList::where(
                                    'id',
                                    $oe->sewing_process_list_id,
                                )
                                    ->pluck('standard_time_sec')
                                    ->first();
                                $standard_time_sec = number_format($standard_time_sec ?? 0, 0);
                            @endphp
                            {{ $standard_time_sec }}
                        </td>
                        <td>
                            @if ($oe->sewing_process_avg_cycles == null)
                                @php $modalId = $oe->id; @endphp
                                <button type="button" class="btn btn-sm btn-outline-dark modal-trigger"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $oe->id }}"
                                    data-modal-id="{{ $oe->id }}"
                                    data-operation-type="{{ $oe->sewing_process_type }}"
                                    data-operation-name="{{ $oe->sewing_process_name }}">Cycle Entry</button>
                            @else
                                @php $modalId = $oe->id; @endphp
                                <button type="button" class="btn btn-sm btn-outline-dark modal-trigger"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $oe->id }}"
                                    data-modal-id="{{ $oe->id }}"
                                    data-operation-type="{{ $oe->sewing_process_type }}"
                                    data-operation-name="{{ $oe->sewing_process_name }}">Add More Cycle Data</button>
                                <br>
                                <input type="text" name="cycles[]"
                                    value="{{ number_format($oe->sewing_process_avg_cycles, 2) }}"
                                    class="form-control cycles-input" readonly>
                            @endif
                        </td>

                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                        <input type="hidden" name="operation_id[]" value="{{ $oe->id }}">
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <a type="button" class="btn btn-lg btn-outline-info" href="{{ route('exam.index') }}">Cancel</a>
    <a type="button" class="btn btn-lg btn-outline-success"
        href="{{ route('exam.matrixData_entry_form', $candidate->id) }}">Next</a>

    @foreach ($entries as $oe)
        <div class="modal fade" id="staticBackdrop{{ $oe->id }}" data-bs-backdrop="static"
            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <form action="{{ route('exam.cyclesData_store') }}" method="post" enctype="multipart/form-data">
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
                                        00:00:00</div>
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
                                data-form-action="{{ route('exam.cyclesData_store') }}">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        // Reuse the same JS logic used in worker entries cycles UI. This captures start/stop/save/reset per modal and collects records.
        const modals = document.querySelectorAll('.modal');
        const modalTriggers = document.querySelectorAll('.modal-trigger');

        // store records per modal id to avoid cross-modal pollution
        let savedRecordsStatus0 = {};
        let savedRecordsStatus1 = {};

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

                // initialize per-modal storage
                if (!savedRecordsStatus0[modalId]) savedRecordsStatus0[modalId] = [];
                if (!savedRecordsStatus1[modalId]) savedRecordsStatus1[modalId] = [];

                function updateClock() {
                    const currentTime = Date.now();
                    const duration1 = currentTime - startTime;
                    display.textContent = formatTime(duration1);
                }

                startBtn.disabled = false;
                stopBtn.disabled = true;
                saveBtn.disabled = true;
                resetBtn.disabled = true;

                // avoid double-binding if modal opened multiple times
                if (startBtn.dataset.bound !== '1') {
                    startBtn.dataset.bound = '1';

                    startBtn.addEventListener('click', () => {
                        startTime = Date.now() - (endTime - startTime);
                        interval = setInterval(updateClock, 1);
                        startBtn.disabled = true;
                        stopBtn.disabled = false;
                        saveBtn.disabled = true;
                        resetBtn.disabled = true;
                        clockContainer.style.border = '10px solid #EE9322';
                    });
                    stopBtn.addEventListener('click', () => {
                        endTime = Date.now();
                        clearInterval(interval);
                        startBtn.disabled = true;
                        stopBtn.disabled = true;
                        saveBtn.disabled = false;
                        resetBtn.disabled = false;
                        clockContainer.style.border = '15px solid #D83F31';
                    });
                    saveBtn.addEventListener('click', () => {
                        const duration = calculateDuration(startTime, endTime);
                        const record = {
                            startTime,
                            endTime,
                            duration,
                            rejectDataStatus: 0
                        };
                        savedRecordsStatus0[modalId].push(record);
                        updateTable(modalId, operationType, operationName, record);
                        clearInterval(interval);
                        resetFields();
                    });

                    resetBtn.addEventListener('click', () => {
                        const duration = calculateDuration(startTime, endTime);
                        const record = {
                            startTime,
                            endTime,
                            duration,
                            rejectDataStatus: 1
                        };
                        savedRecordsStatus1[modalId].push(record);
                        updateTable(modalId, operationType, operationName, record);
                        clearInterval(interval);
                        resetFields();
                    });
                }

                function resetFields() {
                    startTime = 0;
                    endTime = 0;
                    display.textContent = '00:00:00';
                    startBtn.disabled = false;
                    stopBtn.disabled = true;
                    saveBtn.disabled = true;
                    resetBtn.disabled = true;
                    clockContainer.style.border = '3px solid #E9B824';
                }

                function calculateDuration(start, end) {
                    return Math.floor((end - start) / 1000);
                }

                function formatTime(milliseconds) {
                    const minutes = Math.floor((milliseconds / 1000 / 60) % 60);
                    const seconds = Math.floor((milliseconds / 1000) % 60);
                    const miliSeconds = Math.floor(milliseconds % 1000);
                    return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(miliSeconds).padStart(3, '0')}`;
                }

                function formatTimeCalculate(seconds) {
                    const hours = Math.floor(seconds / 3600);
                    const minutes = Math.floor((seconds % 3600) / 60);
                    const remainingSeconds = seconds % 60;
                    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
                }

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

        const ModalsaveBtn = document.querySelectorAll('.ModalsaveBtn');

        ModalsaveBtn.forEach((ModalsaveBtn) => {
            ModalsaveBtn.addEventListener('click', () => {
                const modalId = ModalsaveBtn.getAttribute('data-modal-id');
                const combinedTableData = [...(savedRecordsStatus0[modalId] || []), ...(savedRecordsStatus1[
                    modalId] || [])];
                const tableInput = document.getElementById(`tableData${modalId}`);
                if (tableInput) {
                    tableInput.value = JSON.stringify(combinedTableData);
                } else {
                    console.error(`tableData input not found for modal ${modalId}`);
                }

                // find the form inside this modal and submit it (don't rely on action selector which may match first form)
                const modalEl = document.getElementById(`staticBackdrop${modalId}`);
                if (modalEl) {
                    const form = modalEl.querySelector('form');
                    if (form) {
                        form.submit();
                    } else {
                        console.error(`Form not found inside modal staticBackdrop${modalId}`);
                    }
                } else {
                    console.error(`Modal element staticBackdrop${modalId} not found`);
                }
            });
        });
    </script>

</x-backend.layouts.master>
