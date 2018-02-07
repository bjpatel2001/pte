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
    public $type;
    public function __construct($enquiryData,$type)
    {
        //
        $this->enquiryData = $enquiryData;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->type == 'customer') {
            $to = $this->enquiryData->email;
            $address = 'bjpatel2001@gmail.com';
            $name = 'PTEPromoCode.com';
            $subject = 'Thank you';
            $view = 'emails.enquiry';
        }elseif ($this->type == 'admin') {
            $address = 'bjpatel2001@gmail.com';
            $name = 'PTEPromoCode.com';
            $subject = 'Thank you';
            $to = 'bjpatel2001@gmail.com';
            $view = 'emails.admin_enquiry';
        }

        return $this->view($view)
            ->to($to)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);

    }
}
