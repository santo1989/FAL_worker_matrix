<?php

namespace App\Http\Controllers;

use App\Models\MigrateWorkerList;
use App\Models\TrainingDevelopment;
use App\Models\WorkerEntry;
use Illuminate\Http\Request;

class MigrateWorkerListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('migrate_worker_lists.index');
    }

    
    public function create()
    {
        return view('report.training_development');
    }

    public function training_development()
    {
       
    }

    public function training_development_store(Request $request)
    {
        // dd($request->all());
        try {
            foreach ($request->id_card_no as $key => $id_card_no) {
                // Find the corresponding worker entry
                $workerEntry = WorkerEntry::where('id_card_no', $id_card_no)->first();

                // Ensure worker entry is found
                if (!$workerEntry) {
                    // You can skip this record or throw an exception based on your requirement
                    continue; // Skip to the next iteration
                    // throw new \Exception("Worker entry not found for ID: $id_card_no");
                }
                // dd($workerEntry);
                // training development record creation
                $trainingDevelopment = new TrainingDevelopment();
                $trainingDevelopment->training_date = $request->training_date;
                $trainingDevelopment->worker_entry_id = $workerEntry->id;
                $trainingDevelopment->examination_date = $workerEntry->examination_date;
                $trainingDevelopment->training_name = $request->training_name;
                $trainingDevelopment->id_card_no = $id_card_no;
                $trainingDevelopment->training_duration = $request->training_duration;
                $trainingDevelopment->dataEntryBy = Auth()->user()->name;
                $trainingDevelopment->save();
            }

            return redirect()->route('workerEntries.index')->with('success', 'Training Development Data inserted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MigrateWorkerList  $migrateWorkerList
     * @return \Illuminate\Http\Response
     */
    public function show(MigrateWorkerList $migrateWorkerList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MigrateWorkerList  $migrateWorkerList
     * @return \Illuminate\Http\Response
     */
    public function edit(MigrateWorkerList $migrateWorkerList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MigrateWorkerList  $migrateWorkerList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MigrateWorkerList $migrateWorkerList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MigrateWorkerList  $migrateWorkerList
     * @return \Illuminate\Http\Response
     */
    public function destroy(MigrateWorkerList $migrateWorkerList)
    {
        //
    }
}
