<?php

namespace App\Notifications;

use App\Models\ExamApproval;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApprovalProcessedNotification extends Notification
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
            'type' => 'approval_processed',
            'approval_id' => $this->approval->id,
            'candidate_id' => $this->approval->exam_candidate_id,
            'status' => $this->approval->status,
            'approved_by' => $this->approval->approved_by,
            'message' => 'Promotion ' . $this->approval->status . ' for candidate #' . $this->approval->exam_candidate_id,
        ];
    }
}
