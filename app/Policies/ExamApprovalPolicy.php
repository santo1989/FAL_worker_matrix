<?php

namespace App\Policies;

use App\Models\ExamApproval;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamApprovalPolicy
{
    use HandlesAuthorization;

    /**
     * Before hook: admins can do everything
     */
    public function before(User $user, $ability)
    {
        if ($user->role_id == 1) {
            return true;
        }
    }

    public function create(User $user)
    {
        // any authenticated user can request promotion
        return (bool) $user->id;
    }

    /**
     * Determine whether the user can view the approvals list.
     * Admins, HR (role_id == 4) and GM can view the approvals dashboard.
     */
    public function viewAny(User $user)
    {
        if ($user->role_id == 4) return true; // HR
        if ($user->role && strtolower($user->role->name) === 'gm') return true;
        // admins are already handled by before()
        return false;
    }

    public function approve(User $user, ExamApproval $approval = null)
    {
        // consult approver_roles and approver_users tables
        $approverRoleIds = \App\Models\ApproverRole::pluck('role_id')->toArray();
        $approverUserIds = \App\Models\ApproverUser::pluck('user_id')->toArray();

        if (in_array($user->id, $approverUserIds)) return true;
        if (in_array($user->role_id, $approverRoleIds)) return true;

        // fallback: allow HR (role_id == 4) and GM by role name for backward compatibility
        if ($user->role_id == 4) return true;
        if ($user->role && strtolower($user->role->name) === 'gm') return true;

        return false;
    }

    public function reject(User $user, ExamApproval $approval = null)
    {
        // same as approve
        return $this->approve($user, $approval);
    }
}
