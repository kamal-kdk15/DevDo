<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\CollaborationRequest;
use App\Notifications\CollaborationRequestStatusUpdated;
class SendCollaborationRequestNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $collaborationRequest;
    /**
     * Create a new job instance.
     */
    public function __construct(CollaborationRequest $collaborationRequest)
    {
        $this->collaborationRequest = $collaborationRequest;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
         
            $this->collaborationRequest->idea->user->notify(new CollaborationRequestStatusUpdated($this->collaborationRequest));
            $this->collaborationRequest->user->notify(new CollaborationRequestStatusUpdated($this->collaborationRequest));
        } catch (\Exception $e) {
           
            Log::error('Error sending collaboration request notification: ' . $e->getMessage());
        }
    }
}
