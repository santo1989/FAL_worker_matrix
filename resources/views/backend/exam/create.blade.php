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
    <div class="container">
        <h3>Create Exam Candidate</h3>
        <form action="{{ route('exam.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label>NID</label>
                <input name="nid" class="form-control" required />
            </div>
            <div class="form-group">
                <label>Name</label>
                <input name="name" class="form-control" required />
            </div>
            <div class="form-group mt-2">
                <button class="btn btn-primary">Start Exam</button>
                <a href="{{ route('exam.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</x-backend.layouts.master>
