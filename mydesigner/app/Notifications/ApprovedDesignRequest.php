<?php

namespace MyDesigner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovedDesignRequest extends Notification
{
    use Queueable;
    protected $emailContent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($emailContent)
    {
        $this->emailContent = $emailContent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = sprintf( '[%s] Design Request Approved', config('app.name') );

        $site_title = config('app.name');

        return (new MailMessage)
            ->from('lester@podcastwebsites.com')
            ->subject($subject)
            ->view( 'mails.designs.approved', [ 'site_title' => $site_title, 'emailContent' => $this->emailContent ] );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
