<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Order;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //kirim email sebagai subjek berikut
        //template yg digunakan adl order.blade.php yg ada difolder emails
        //dan passing data ke order file order.blade.php
        return $this->subject('Pesanan Anda dikirim'. $this->order->invoice)
                    ->view('email.order')->with(['order=>$this->order']);

        // return $this->view('view.name');
    }
}
