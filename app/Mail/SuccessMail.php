<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $successData;
    public function __construct($successData)
    {
        //
        $this->successData = $successData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $address = 'help@ptevouchercode.com';
        $name = 'PTEVoucherCode.com';
        $bcc = 'hitesh.53310@gmail.com';
        if($this->successData['type'] == 'admin') {
            $to = 'hitesh.53310@gmail.com';
            $view = 'emails.success_admin';
            $subject = 'Success';
        }else {
            $to = $this->successData['email'];
            $view = 'emails.success_customer';
            $subject = 'PTE Voucher Code';
        }

        return $this->view($view)
            ->to($to)
            ->from($address, $name)
            ->bcc($bcc, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
