<?php

namespace App\Notifications;

use App\Models\CollaborationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
class CollaborationRequestReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $request;
    public function __construct(CollaborationRequest $request)
    {
        $this->request = $request;
    }

  
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        try {
            return (new MailMessage)
                ->line('You have received a new collaboration request.')
                ->action('View Request', route('profile.requests'))
                ->line('Thank you for using our application!');
        } catch (\Exception $e) {
            Log::error('Error in CollaborationRequestReceived notification: ' . $e->getMessage());
        
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
