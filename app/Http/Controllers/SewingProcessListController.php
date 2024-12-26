<?php

namespace App\Http\Controllers;

use App\Models\SewingProcessList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SewingProcessListController extends Controller
{
    public function index()
    {
        $sewingProcessList = SewingProcessList::all();
        return view('backend.library.sewingProcessList.index', compact('sewingProcessList'));
    }


    public function create()
    {
        $sewingProcessList = SewingProcessList::all();
        return view('backend.library.sewingProcessList.create', compact('sewingProcessList'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'process_name' => 'array|required|min:1|max:191',
            'process_type' => 'required',
            'machine_type' => 'required',
            'smv' => 'required',
            'standard_capacity' => 'required',
            'standard_time_sec' => 'required',

        ]);

        try {
            // Data insert
            foreach ($request->process_name as $key => $value) {
                $sewingProcessListold = SewingProcessList::all();
                $sewingProcessList = new SewingProcessList;

                foreach ($sewingProcessListold as $sewingProcessListold) {
                    if ($sewingProcessListold->process_name == ucwords($request->process_name[$key])) {
                        return redirect()->route('sewingProcessList.index')->withMessage('SewingProcessList is already exists!');
                    }
                }

                $sewingProcessList->process_type = $request->process_type;
                $sewingProcessList->machine_type = $request->machine_type;
                $sewingProcessList->process_name = ucwords($request->process_name[$key]);
                $sewingProcessList->standard_capacity = $request->standard_capacity[$key];
                $sewingProcessList->standard_time_sec = $request->standard_time_sec[$key];
                $sewingProcessList->dataEntryBy = Auth::user()->name;
                $sewingProcessList->dataEntryDate = date("Y-m-d H:i:s");
        
                $sewingProcessList->save();
            }
            return redirect()->route('sewingProcessList.index')->withMessage('SewingProcessList is created successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('sewingProcessList.index')->withError($th->getMessage());
        }
    }


    public function show($id)
    {
        $sewingProcessList = SewingProcessList::findOrFail($id);
        return view('backend.library.sewingProcessList.show', compact('sewingProcessList'));
    }


    public function edit($id)
    {
        $sewingProcessList = SewingProcessList::findOrFail($id);
        return view('backend.library.sewingProcessList.edit', compact('sewingProcessList'));
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'process_name' => 'required|min:1|max:191',
            'process_type' => 'required',
            'machine_type' => 'required',

        ]);

        try {

            // Data update
            $sewingProcessList = SewingProcessList::findOrFail($id);
            $sewingProcessList->process_name = ucwords($request->process_name);
            $sewingProcessList->process_type = $request->process_type;
            $sewingProcessList->machine_type = $request->machine_type;
            $sewingProcessList->standard_capacity = $request->standard_capacity;
            $sewingProcessList->standard_time_sec = $request->standard_time_sec;
            $sewingProcessList->dataEditBy = Auth::user()->name;
            $sewingProcessList->dataEditDate = date("Y-m-d H:i:s");
            $sewingProcessList->save();

            return redirect()->route('sewingProcessList.index')->withMessage('SewingProcessList is Updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('sewingProcessList.index')->withError($th->getMessage());
        }
    }


    public function destroy($id)
    {
        $sewingProcessList = SewingProcessList::findOrFail($id);

        $sewingProcessList->delete();

        return redirect()->route('sewingProcessList.index')->withMessage('SewingProcessList is deleted successfully!');
    }

    public function sewingProcessList_active($id)
    {
        $spl = SewingProcessList::findOrFail($id);
        if ($spl->is_active == 0) {
            $spl->is_active = 1;
        } else {
            $spl->is_active = 0;
        }
        $spl->save();
        return redirect()->route('sewingProcessList.index')->withMessage('SewingProcessList is Actived successfully!');
    }
}
