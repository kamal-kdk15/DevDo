<?php

namespace App\Notifications;

use App\Models\CollaborationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
class CollaborationRequestStatusUpdated extends Notification
{
    use Queueable;

   protected $request;
    public function __construct(CollaborationRequest $request)
    {
        $this->request = $request;
    }


    public function via($notifiable)
    {
     
        return ['mail', 'database'];
    }

  
    public function toMail(object $notifiable)
    {
        try {
            return (new MailMessage)
                ->line('Your collaboration request has been ' . $this->request->status . '.')
                ->action('View Request', url('/profile/requests'))
                ->line('Thank you for using our application!');
        } catch (\Exception $e) {
            Log::error('Error in CollaborationRequestStatusUpdated notification: ' . $e->getMessage());
        
            return null; 
        }
    }

  
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->request->user_id,
            'idea_id' => $this->request->idea_id,
            'status' => $this->request->status,
        ];
    }
}
