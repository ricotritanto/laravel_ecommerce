<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $customer;
    protected $randomPassword;
    //meminta  data berupa informasi customer dan random password yg blm di encrypt
    public function __construct(Customer $customer, $randomPassword)
    {
        $this->customer = $customer;
        $this->randomPassword = $randomPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        //mengeset subject email, view mana  yg akan diload  dan data apa yg akan dipasang ke view
        return $this->subject('verifikasi pendaftaran anda')
            ->view('emails.register')
            ->with([
                'customer' => $this->customer,
                'password' => $this->randomPassword
            ]);
    }
}
