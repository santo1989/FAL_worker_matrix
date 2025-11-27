<?php

namespace App\Notifications;

use App\Models\ExamApproval;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class ApprovalRequestedNotification extends Notification
{
    use Queueable;

    protected $approval;

    public function __construct(ExamApproval $approval)
    {
        $this->approval = $approval;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'approval_requested',
            'approval_id' => $this->approval->id,
            'candidate_id' => $this->approval->exam_candidate_id,
            'requested_by' => $this->approval->requested_by,
            'requested_salary' => $this->approval->requested_salary,
            'message' => 'Promotion requested for candidate #' . $this->approval->exam_candidate_id,
        ];
    }
}
