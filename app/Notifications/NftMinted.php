<?php

namespace App\Notifications;

use App\Models\Nft;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class NftMinted extends Notification
{
    use Queueable;

    private Nft $nft;

    public function __construct(Nft $nft)
    {
        $this->nft = $nft;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFcm($notifiable)
    {
        return FcmMessage::create()
                         ->setData(['nft_id' => $this->nft->id])
                         ->setNotification(FcmNotification::create()
                                                          ->setTitle('Mint successful')
                                                          ->setBody('Your NFT has been minted successfully!')
                         );
    }
}
