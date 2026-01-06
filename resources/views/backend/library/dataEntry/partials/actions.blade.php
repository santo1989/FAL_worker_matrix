<td>
    @can('General')
        <x-backend.form.anchor :href="route('workerEntries.edit', $workerEntry)" type="edit" />

        <form style="display:inline" action="{{ route('workerEntries.destroy', ['workerEntry' => $workerEntry->id]) }}"
            method="POST">
            @csrf
            @method('delete')
            <button onclick="return confirm('Are you sure want to delete ?')" class="btn btn-outline-danger my-1 mx-1 btn-sm"
                type="submit">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    @endcan
    <x-backend.form.anchor :href="route('workerEntries.show', $workerEntry)" type="show" />
    <x-backend.form.anchor :href="route('workerEntries.approval', $workerEntry)" type="Download" />
    <!--printPage-->
    <x-backend.form.anchor :href="route('printPage', $workerEntry)" type="PrintPage" />
    @can('General')
        <a href="{{ route('cyclesData_entry_form', ['workerEntry' => $workerEntry->id]) }}"
            class="btn btn-outline-success my-1 mx-1 btn-sm">
            <i class="bi bi-file"></i> Cycle Entry
        </a>
    @endcan
    @can('Admin')
        <a href="{{ route('cyclesData_entry_form', ['workerEntry' => $workerEntry->id]) }}"
            class="btn btn-outline-success my-1 mx-1 btn-sm">
            <i class="bi bi-file"></i> Cycle Entry
        </a>
        <x-backend.form.anchor :href="route('workerEntries.edit', $workerEntry)" type="edit" />
        <form style="display:inline" action="{{ route('workerEntries.destroy', ['workerEntry' => $workerEntry->id]) }}"
            method="POST">
            @csrf
            @method('delete')
            <button onclick="return confirm('Are you sure want to delete ?')"
                class="btn btn-outline-danger my-1 mx-1 btn-sm" type="submit">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    @endcan
    @can('Supervisor')
        <a href="{{ route('cyclesData_entry_form', ['workerEntry' => $workerEntry->id]) }}"
            class="btn btn-outline-success my-1 mx-1 btn-sm">
            <i class="bi bi-file"></i> Cycle Entry
        </a>
        <x-backend.form.anchor :href="route('workerEntries.edit', $workerEntry)" type="edit" />
        <form style="display:inline" action="{{ route('workerEntries.destroy', ['workerEntry' => $workerEntry->id]) }}"
            method="POST">
            @csrf
            @method('delete')
            <button onclick="return confirm('Are you sure want to delete ?')"
                class="btn btn-outline-danger my-1 mx-1 btn-sm" type="submit">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    @endcan
</td>
