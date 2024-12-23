<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Disciplinary Problems
    </x-slot>
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Disciplinary Problems
                    </div>
                    <form action="{{ route('disciplinary_problems_store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="disciplinary_problem_date">Date</label>
                                    <input type="date" name="disciplinary_problem_date"
                                        id="disciplinary_problem_date" class="form-control"
                                        placeholder="Enter Training Date" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row mt-3" id="dynamic_field">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="id_card_no">ID Card No / Name</label>
                                        <select name="id_card_no[]" class="form-control id_card_no" required>
                                            @php
                                                $current_year = date('Y');
                                                $workerEntries = \App\Models\WorkerEntry::where(
                                                    'examination_date',
                                                    'like',
                                                    $current_year . '%',
                                                )->get();
                                            @endphp
                                            <option value="">Select ID Card No / Name</option>
                                            @foreach ($workerEntries as $workerEntry)
                                                <option value="{{ $workerEntry->id_card_no }}">
                                                    {{ $workerEntry->id_card_no }}:
                                                    {{ $workerEntry->employee_name_english }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="disciplinary_problem_description">Remarks</label>
                                        <textarea name="disciplinary_problem_description[]" class="form-control disciplinary_problem_description"
                                            placeholder="Enter Disciplinary Problem Description"></textarea>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button type="button" name="add" id="add" class="btn btn-outline-success mt-4">Add
                                        More</button>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="{{ route('home') }}" class="btn btn-outline-danger"><i class="fas fa-times"></i>
                                Cancel</a>
                            <button type="submit" class="btn btn-outline-success"><i class="fas fa-save"></i>
                                Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <script>
      $(document).ready(function() {
              var i = 1;
    // Function to initialize Select2 for the id_card_no dropdown
    function initializeSelect2() {
        $('.id_card_no').select2({
            // Add Select2 options here if needed
        });
    }

    // Call initializeSelect2 initially
    initializeSelect2();

    // Add event listener for "Add More" button
    $('#add').click(function() {
        var dynamicField = '<div class="row mt-3" id="row' + i + '">' +
            '<div class="col-3">' +
            '<div class="form-group">' +
            '<label for="id_card_no">ID Card No / Name</label>' +
            '<select name="id_card_no[]" class="form-control id_card_no" required>' +
            $('.id_card_no').html() +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-6">' +
            '<div class="form-group">' +
            '<label for="disciplinary_problem_description">Remarks</label>' +
            '<textarea name="disciplinary_problem_description[]" class="form-control disciplinary_problem_description" placeholder="Enter Disciplinary Problem Description"></textarea>' +
            '</div>' +
            '</div>' +
            '<div class="col-3">' +
            '<button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove mt-4">Remove</button>' +
            '</div>' +
            '</div>';

        $('#dynamic_field').append(dynamicField);

        // Increment i for the next dynamic field
        i++;

        // Reinitialize Select2 for the newly added dropdown
        initializeSelect2();
    });

    // Remove event listener
    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
});

    </script>
    


</x-backend.layouts.master>
