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

        $address = 'pteacademicvouchercode.com';
        $name = 'PTEPromoCode.com';
        if($this->successData['type'] == 'admin') {
            $to = 'pteacademicvouchercode';
            $view = 'emails.success_admin';
            $subject = 'Success';
        }elseif ($this->successData['type'] == 'customer'){
            $to = $this->successData['email'];
            $view = 'emails.success_customer';
            $subject = 'PTE Promo Code';
        }elseif($this->successData['type'] == 'send_query'){
            $to = 'pteacademicvouchercode';
            $view = 'emails.customer_contactus';
            $subject = 'Customer Enquiry';
        }elseif ($this->successData['type'] == 'mock_test') {
            $to = $this->successData['email'];
            $view = 'emails.mock_test.blade';
            $subject = 'PTE Mock Test';
        }

        return $this->view($view)
            ->to($to)
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject);
    }
}
