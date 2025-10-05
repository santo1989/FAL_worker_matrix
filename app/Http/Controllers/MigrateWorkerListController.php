<?php

namespace App\Http\Controllers;

use App\Models\MigrateWorkerList;
use App\Models\TrainingDevelopment;
use App\Models\WorkerEntry;
use App\Models\WorkerSewingProcessEntry;
use App\Models\CycleListLog;
use App\Models\DisciplinaryProblem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MigrateWorkerListController extends Controller
{
    public function index(Request $request)
    {
        $query = MigrateWorkerList::with(['user'])
            ->orderBy('migration_date', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id_card_no', 'like', "%{$search}%")
                    ->orWhere('employee_name_english', 'like', "%{$search}%")
                    ->orWhere('migration_reason', 'like', "%{$search}%");
            });
        }

        // Filter by migration reason
        if ($request->has('migration_reason') && $request->migration_reason != '') {
            $query->where('migration_reason', $request->migration_reason);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date != '') {
            $query->where('migration_date', '>=', $request->from_date);
        }
        if ($request->has('to_date') && $request->to_date != '') {
            $query->where('migration_date', '<=', $request->to_date);
        }

        // Filter by migrate month
        if ($request->has('migrate_month') && $request->migrate_month != '') {
            $query->where('migrate_month', $request->migrate_month);
        }

        $migrateWorkerLists = $query->paginate(20);

        // Debug: Check for missing IDs
        foreach ($migrateWorkerLists as $migration) {
            if (empty($migration->id)) {
                Log::warning('MigrateWorkerList record with missing ID detected', [
                    'record' => $migration->toArray()
                ]);
            }
        }

        return view('backend.library.hr.migrate_worker_lists.index', compact('migrateWorkerLists'));
    }

    public function create()
    {
        $workers = WorkerEntry::whereNull('old_matrix_Data_status')
            ->whereNotIn('id', function ($query) {
                $query->select('original_worker_entry_id')
                    ->from('migrate_worker_lists');
            })
            ->orderBy('employee_name_english')
            ->get();
        return view('backend.library.hr.migrate_worker_lists.create', compact('workers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'worker_entry_id' => 'required|exists:worker_entries,id',
            'migration_reason' => 'required|in:resigned,terminated,retired,transferred,inactive,other',
            'migration_date' => 'required|date',
            'last_working_date' => 'required|date',
            'last_salary' => 'nullable|numeric',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $worker = WorkerEntry::with([
                'sewingProcessEntries',
                'cycleListLogs',
                'trainingDevelopments',
                'disciplinaryProblems'
            ])->findOrFail($validated['worker_entry_id']);

            $joiningDate = Carbon::parse($worker->joining_date);
            $lastWorkingDate = Carbon::parse($validated['last_working_date']);
            $serviceLength = $this->calculateServiceLength($joiningDate, $lastWorkingDate);

            $workerEntryData = $worker->toArray();
            $sewingProcessEntriesData = $worker->sewingProcessEntries->toArray();
            $cycleListLogsData = $worker->cycleListLogs->toArray();
            $trainingDevelopmentsData = $worker->trainingDevelopments->toArray();
            $disciplinaryProblemsData = $worker->disciplinaryProblems->toArray();

            $migrateWorkerList = MigrateWorkerList::create([
                'original_worker_entry_id' => $worker->id,
                'worker_entry_data' => $workerEntryData,
                'sewing_process_entries_data' => $sewingProcessEntriesData,
                'cycle_list_logs_data' => $cycleListLogsData,
                'training_developments_data' => $trainingDevelopmentsData,
                'disciplinary_problems_data' => $disciplinaryProblemsData,
                'id_card_no' => $worker->id_card_no,
                'employee_name_english' => $worker->employee_name_english,
                'migration_reason' => $validated['migration_reason'],
                'migration_date' => $validated['migration_date'],
                'last_working_date' => $validated['last_working_date'],
                'service_length' => $serviceLength,
                'last_salary' => $validated['last_salary'] ?? $worker->salary,
                'migrate_month' => Carbon::parse($validated['migration_date'])->format('Y-m'),
                'data_entry_by' => Auth::user()->name,
                'user_id' => Auth::id(),
                'notes' => $validated['notes'],
            ]);

            CycleListLog::where('worker_entry_id', $worker->id)->delete();
            WorkerSewingProcessEntry::where('worker_entry_id', $worker->id)->delete();
            TrainingDevelopment::where('worker_entry_id', $worker->id)->delete();
            DisciplinaryProblem::where('worker_entry_id', $worker->id)->delete();
            $worker->delete();

            DB::commit();
            return redirect()->route('migrate-worker-lists.index')
                ->with('success', 'Worker successfully migrated with all data. All original records have been deleted.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Migration failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Migration failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function mwlshow($id)
    {
        $migrateWorkerList = MigrateWorkerList::where('original_worker_entry_id', $id)
            ->firstOrFail();
        $workerEntry = $migrateWorkerList->workerEntry;
        $sewingProcessEntries = $migrateWorkerList->sewingProcessEntries;
        $cycleListLogs = $migrateWorkerList->cycleListLogs;
        $trainingDevelopments = $migrateWorkerList->trainingDevelopments;
        $disciplinaryProblems = $migrateWorkerList->disciplinaryProblems;

        $curiosity_to_lern = $sewingProcessEntries->filter(function ($entry) {
            return empty($entry->smv) &&
                empty($entry->sewing_process_avg_cycles) &&
                empty($entry->capacity) &&
                empty($entry->self_production) &&
                empty($entry->achive_production);
        });

        return view('backend.library.hr.migrate_worker_lists.report', compact(
            'migrateWorkerList',
            'workerEntry',
            'sewingProcessEntries',
            'cycleListLogs',
            'trainingDevelopments',
            'disciplinaryProblems',
            'curiosity_to_lern'
        ));
    }

    public function mwledit($id)
    {
        $migrateWorkerList = MigrateWorkerList::where('original_worker_entry_id', $id)
            ->firstOrFail();
        return view('backend.library.hr.migrate_worker_lists.edit', compact('migrateWorkerList'));
    }

    public function mwlupdate(Request $request, $id)
    {
        $migrateWorkerList = MigrateWorkerList::where('original_worker_entry_id', $id)
            ->firstOrFail();

        // dd($migrateWorkerList);
        $validated = $request->validate([
            'migration_reason' => 'required|in:resigned,terminated,retired,transferred,inactive,other',
            'migration_date' => 'required|date',
            'last_working_date' => 'required|date',
            'last_salary' => 'nullable|numeric',
            'notes' => 'nullable|string|max:1000',
        ]);
        


        try {
            if ($migrateWorkerList->last_working_date != $validated['last_working_date']) {
                $workerEntryData = (array) $migrateWorkerList->workerEntry;
                $joiningDate = Carbon::parse($workerEntryData['joining_date']);
                $lastWorkingDate = Carbon::parse($validated['last_working_date']);
                $serviceLength = $this->calculateServiceLength($joiningDate, $lastWorkingDate);
                $validated['service_length'] = $serviceLength;
            }

            if ($migrateWorkerList->migration_date != $validated['migration_date']) {
                $validated['migrate_month'] = Carbon::parse($validated['migration_date'])->format('Y-m');
            }

            $migrateWorkerList->update($validated);
            return redirect()->route('migrate-worker-lists.index')
                ->with('success', 'Migration record updated successfully.');
        } catch (\Exception $e) {
            Log::error('Migration update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Update failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function mwlDestroy($id)
    {
        $migrateWorkerList = MigrateWorkerList::where('original_worker_entry_id', $id)
            ->firstOrFail();
            // dd($migrateWorkerList);
        try {
            $migrateWorkerList->delete();
            return redirect()->route('migrate-worker-lists.index')
                ->with('success', 'Migration record deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Migration deletion failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }

    public function bulkCreate()
    {
        $workers = WorkerEntry::whereNull('old_matrix_Data_status')
            ->whereNotIn('id', function ($query) {
                $query->select('original_worker_entry_id')
                    ->from('migrate_worker_lists');
            })
            ->orderBy('employee_name_english')
            ->get();
        return view('backend.library.hr.migrate_worker_lists.bulk_create', compact('workers'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'worker_entries' => 'required|array',
            'worker_entries.*' => 'exists:worker_entries,id',
            'migration_reason' => 'required|in:resigned,terminated,retired,transferred,inactive,other',
            'migration_date' => 'required|date',
            'last_working_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $migratedCount = 0;
            foreach ($validated['worker_entries'] as $workerId) {
                $worker = WorkerEntry::with([
                    'sewingProcessEntries',
                    'cycleListLogs',
                    'trainingDevelopments',
                    'disciplinaryProblems'
                ])->find($workerId);
                if ($worker) {
                    $joiningDate = Carbon::parse($worker->joining_date);
                    $lastWorkingDate = Carbon::parse($validated['last_working_date']);
                    $serviceLength = $this->calculateServiceLength($joiningDate, $lastWorkingDate);

                    $workerEntryData = $worker->toArray();
                    $sewingProcessEntriesData = $worker->sewingProcessEntries->toArray();
                    $cycleListLogsData = $worker->cycleListLogs->toArray();
                    $trainingDevelopmentsData = $worker->trainingDevelopments->toArray();
                    $disciplinaryProblemsData = $worker->disciplinaryProblems->toArray();

                    MigrateWorkerList::create([
                        'original_worker_entry_id' => $worker->id,
                        'worker_entry_data' => $workerEntryData,
                        'sewing_process_entries_data' => $sewingProcessEntriesData,
                        'cycle_list_logs_data' => $cycleListLogsData,
                        'training_developments_data' => $trainingDevelopmentsData,
                        'disciplinary_problems_data' => $disciplinaryProblemsData,
                        'id_card_no' => $worker->id_card_no,
                        'employee_name_english' => $worker->employee_name_english,
                        'migration_reason' => $validated['migration_reason'],
                        'migration_date' => $validated['migration_date'],
                        'last_working_date' => $validated['last_working_date'],
                        'service_length' => $serviceLength,
                        'last_salary' => $worker->salary,
                        'migrate_month' => Carbon::parse($validated['migration_date'])->format('Y-m'),
                        'data_entry_by' => Auth::user()->name,
                        'user_id' => Auth::id(),
                        'notes' => $validated['notes'],
                    ]);

                    CycleListLog::where('worker_entry_id', $worker->id)->delete();
                    WorkerSewingProcessEntry::where('worker_entry_id', $worker->id)->delete();
                    TrainingDevelopment::where('worker_entry_id', $worker->id)->delete();
                    DisciplinaryProblem::where('worker_entry_id', $worker->id)->delete();
                    $worker->delete();
                    $migratedCount++;
                }
            }
            DB::commit();
            return redirect()->route('migrate-worker-lists.index')
                ->with('success', "Successfully migrated {$migratedCount} workers. All original records have been deleted.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk migration failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Bulk migration failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function export(Request $request)
    {
        $migrateWorkerLists = MigrateWorkerList::when($request->migration_reason, function ($query, $reason) {
            return $query->where('migration_reason', $reason);
        })->when($request->migrate_month, function ($query, $month) {
            return $query->where('migrate_month', $month);
        })->get();
        return response()->json($migrateWorkerLists);
    }

    private function calculateServiceLength($joiningDate, $lastWorkingDate)
    {
        $years = $joiningDate->diffInYears($lastWorkingDate);
        $months = $joiningDate->diffInMonths($lastWorkingDate) % 12;
        $days = $joiningDate->diffInDays($lastWorkingDate) % 30;
        return "{$years} years {$months} months {$days} days";
    }
}
