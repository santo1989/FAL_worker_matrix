<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Operator Assessment Sheet List
    </x-slot>


<div class="card">
    <div class="card-header">
        <h5 class="card-title">Upload Worker Data Excel</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form action="{{ route('workerEntries.uploadExcel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="excel_file">Excel File</label>
                <input type="file" name="excel_file" id="excel_file" class="form-control-file @error('excel_file') is-invalid @enderror" accept=".xlsx,.xls">
                @error('excel_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Supported formats: .xlsx, .xls (Max: 10MB). File must follow the required format.
                </small>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload Excel
                </button>
                <a href="{{ route('workerEntries.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </form>

        <div class="mt-4">
            <h6>Excel File Format Requirements:</h6>
            <ul>
                <li>Must contain columns: floor, line, employee_name_english, id_card_no, joining_date, designation_name, present_grade, recomanded_grade, recomanded_salary, experience, salary, examination_date</li>
                <li>ID Card numbers must be unique</li>
                <li>Dates should be in YYYY-MM-DD format</li>
            </ul>
        </div>
    </div>
</div>

</x-backend.layouts.master>