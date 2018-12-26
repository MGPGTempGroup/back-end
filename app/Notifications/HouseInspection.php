<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

use App\HouseInspection as HouseInspectionModel;

/**
 * 房屋预约通知
 */
class HouseInspection extends Notification
{
    use Queueable;

    /**
     * HouseInspection模型实例
     *
     * @var object
     */
    protected $houseInspection;

    /**
     * 房屋基本信息：ID、Name等字段
     *
     * @var array
     */
    protected $houseInfo;

    /**
     * HouseInspection constructor.
     *
     * @param HouseInspectionModel $houseInspection 房屋预约检查模型实例
     * @param array $houseInfo 房屋基本信息：ID、Name等字段
     */
    public function __construct(HouseInspectionModel $houseInspection, array $houseInfo)
    {
        $this->houseInspection = $houseInspection;
        $this->houseInfo = $houseInfo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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

    public function toDatabase($notifiable)
    {
        return [
            'house_name' => $this->houseInfo['name'],
            'house_id' => $this->houseInfo['id'],
            'applicant_name' => implode([
                $this->houseInspection->first_name,
                $this->houseInspection->surname
            ], ' '),
            'comment' => $this->houseInspection->comment
        ];
    }
}
