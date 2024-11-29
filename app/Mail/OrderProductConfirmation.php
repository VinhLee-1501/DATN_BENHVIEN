<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderProductConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $orderProduct;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderProduct)
    {
        $this->orderProduct = $orderProduct;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orderProduct-confirmation')
                    ->subject('Xác nhận đặt lịch khám')
                    ->with([
                        'orderProducts' => $this->orderProduct
                    ]);
    }
}
