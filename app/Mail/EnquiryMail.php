<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $enquiryData;
    public $user_name;
    public function __construct($enquiryData)
    {
        //
        $this->enquiryData = $enquiryData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->user_name = $this->enquiryData->name;
        $address = 'help@ptevouchercode.com';
        $name = 'PTEVoucherCode.com';
        $subject = 'Thank you';
        $bcc = 'hitesh.53310@gmail.com';

        return $this->view('emails.enquiry')
            ->to($this->enquiryData->email)
            ->from($address, $name)
            ->bcc($bcc, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with($this->user_name,$this->enquiryData->name);
    }
}
