<?php

namespace App\Http\Controllers;

use App\Models\ApproverRole;
use App\Models\ApproverUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApproverSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show roles and users to select who are approvers
    public function index()
    {
        // only admin
        if (Auth::user()->role_id != 1) {
            abort(403);
        }

        $roles = Role::orderBy('id')->get();
        $users = User::orderBy('name')->get();

        $selectedRoleIds = ApproverRole::pluck('role_id')->toArray();
        $selectedUserIds = ApproverUser::pluck('user_id')->toArray();

        return view('backend.settings.approver_settings', compact('roles', 'users', 'selectedRoleIds', 'selectedUserIds'));
    }

    // Save selections
    public function update(Request $request)
    {
        if (Auth::user()->role_id != 1) {
            abort(403);
        }

        $roleIds = $request->input('role_ids', []);
        $userIds = $request->input('user_ids', []);

        // Sync approver_roles
        ApproverRole::truncate();
        foreach ($roleIds as $rid) {
            ApproverRole::create(['role_id' => (int)$rid]);
        }

        // Sync approver_users
        ApproverUser::truncate();
        foreach ($userIds as $uid) {
            ApproverUser::create(['user_id' => (int)$uid]);
        }

        return redirect()->back()->with('success', 'Approver settings saved.');
    }
}
