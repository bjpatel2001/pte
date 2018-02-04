<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\PendingVoucher;
use App\Models\Prize;
use App\Models\Promo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pte;
use Validator;
use DB;


class PteController extends Controller
{

    protected $pte;
    protected $promo;
    protected $prize;
    protected $enquiry;
    protected $pendingVoucher;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Pte $pte,Promo $promo,Prize $prize, Enquiry $enquiry,PendingVoucher $pendingVoucher)
    {
       // $this->middleware(['auth', 'checkRole']);
        $this->pte = $pte;
        $this->promo = $promo;
        $this->prize = $prize;
        $this->enquiry = $enquiry;
        $this->pendingVoucher = $pendingVoucher;

    }

    /**
     * Validation of add and edit action customeValidate
     *
     * @param array $data
     * @param string $mode
     * @return mixed
     */
    public function customeValidate($data)
    {
        $rules = array(
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|integer|min:10',
            'number_of_voucher' => 'required',
            'state' => 'required'
        );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errorRedirectUrl = "/";
            return redirect($errorRedirectUrl)->withInput()->withErrors($validator);
        }
        return false;
    }



    /**
     * Create payment request and redirect to payment gateway.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function createPaymentRequest(request $request)
    {
        $request_data = $request->all();
        $buying_quantity = intval($request_data['number_of_voucher']);
        //$addpromo = $this->promo->addPromo($request->all());
        $unused_voucher = $this->promo->getUnusedVoucher();
        if($buying_quantity > $unused_voucher) {
            $request->session()->flash('alert-danger', 'Total number of voucher available is '.$unused_voucher);
            return redirect('/')->withInput();
        }

        //Get the current rate of voucher
        $current_prize_data = $this->prize->getFirstPrize();
        if(count($current_prize_data) > 0) {
            $current_prize = $current_prize_data->rate;
            $request_data['amount'] = $buying_quantity * $current_prize;
        }else {
            $request->session()->flash('alert-danger', 'Voucher prize is not available please visit after some time');
            return redirect('/')->withInput();
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:4b3ab11a54e5b85da7893b10f4fde169",
                "X-Auth-Token:01f2f923def1bd1ca18a6e5a2543f3f8"));
        $payload = Array(
            'purpose' => 'PTE Voucher Payment',
            'amount' => $request_data['amount'],
            'phone' => $request_data['mobile'],
            'buyer_name' => $request_data['name'],
            'redirect_url' => 'http://ptetutorialsonline.com/redirect',
            'send_email' => false,
            'webhook' => 'http://ptetutorialsonline.com/webhook',
            'send_sms' => false,
            'email' => $request_data['email'],
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response,true);
        $request_data['payment_request_id'] = $result["payment_request"]["id"];

        //Insert into enquiry

        $enquiry_data = $this->enquiry->addEnquiry($request_data);
        if($enquiry_data) {
            $number_of_voucher = $enquiry_data->number_of_voucher;
            $voucher_id = [];
            $voucher_data = $this->promo->getVoucherByCount($number_of_voucher);
            if(count($voucher_data) > 0) {
                foreach ($voucher_data as $voucher ) {
                    $voucher_id[] = $voucher->id;
                    $request_promo = [];
                    $request_promo['status'] = 2;
                    $request_promo['id'] = $voucher->id;
                    $this->promo->updateStatus($request_promo);
                }
            }
            $voucher_id = implode(",",$voucher_id);

            //For adding the voucher code to the mediator table
            $request_pending_data = [];
            $request_pending_data['voucher_id'] = $voucher_id;
            $request_pending_data['enquiry_id'] = $enquiry_data->id;
            $this->pendingVoucher->addPendingVoucher($request_pending_data);

        }
        return redirect($result["payment_request"]["longurl"]);

    }
    /**
     * Create payment request and redirect to payment gateway.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkPaymentStatus(request $request)
    {
        $request_data = $request->all();

        if(isset($request_data['payment_id']) && isset($request_data['payment_request_id'])) {
            $PaymentRequestId = $request_data["payment_request_id"];
            $PaymentId = $request_data["payment_id"];
            if(!empty($PaymentRequestId) && !empty($PaymentId)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.instamojo.com/api/1.1/payments/$PaymentId");
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array("X-Api-Key:4b3ab11a54e5b85da7893b10f4fde169",
                        "X-Auth-Token:01f2f923def1bd1ca18a6e5a2543f3f8"));

                $response = curl_exec($ch);
                curl_close($ch);

                $result = json_decode($response, true);

                $success = $result["success"];
                $payment_request_status = $result['payment']['status'];
                $amount_paid = $result['payment']['amount'];
                $instamojo_fee = $result['payment']['fees'];
                $payment_id = $result['payment']['payment_id'];


                //After payment get credited and successful
                if(intval($success)==1)
                {
                    if($payment_request_status == "Credit")
                    {
                        //Fetch the user detail and voucher detail
                        $user_detail = $this->enquiry->getEnquiryByField($PaymentRequestId,'payment_request_id');
                        if(count($user_detail) > 0) {
                          $enquiry_id = $user_detail->id;
                          $number_of_voucher =  $user_detail->number_of_voucher;
                          $email =  $user_detail->email;
                          $name =  $user_detail->name;
                          $mobile =  $user_detail->mobile;
                          $rate =  $user_detail->rate;
                          $actual_amount = intval($number_of_voucher) * intval($rate);
                          if($amount_paid != $actual_amount) {
                              $request->session()->flash('alert-danger', 'Payment amount is not matching the voucher total amount');
                              return redirect('/')->withInput();
                          }
                          $pending_voucher_detail = $this->pendingVoucher->getPendingVoucherByField($enquiry_id,'enquiry_id');
                          if(count($pending_voucher_detail) > 0) {
                              $row_voucher_data = $pending_voucher_detail->voucher_id;
                              $voucher_id = explode(",",$pending_voucher_detail->voucher_id);
                              foreach($voucher_id as $voucher) {
                                  $update_voucher_data = [];
                                  $update_voucher_data['status'] = 1;
                                  $update_voucher_data['id'] = $voucher;
                                  $this->promo->updateStatus($update_voucher_data);
                              }

                              //@TODO : send here the success mail and SMS to both admin and user and also enter the entry into the sell data table which need to be created
                          }
                        }else {
                            $request->session()->flash('alert-danger', 'Payment request id not available please contact admin');
                            return redirect('/')->withInput();
                        }
                    }
                }
            }
        }
    }


}
