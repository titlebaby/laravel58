<?php

namespace App\Notifications;

use App\Model\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * 支付通知类
 * Class InvoicePaid
 * @package App\Notifications
 */
class InvoicePaid extends Notification implements ShouldQueue
{
    /**
     * Laravel 会自动检测到 ShouldQueue 接口然后将通知推送到队列：
     */
    use Queueable;

    private $invoice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/invoice/'.$this->invoice->id);
        return (new MailMessage)
            ->greeting('Hello!')
            ->subject("消费账单通知")
            ->line('The introduction to the notification.')
            ->action('查看账单详情', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id'    => $notifiable->id,
            'invoice_id' => $this->invoice->id,
            'amount'     => $this->invoice->amount,
        ];
    }
}
