<?php

namespace App\Http\Controllers;

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


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Pte $pte,Promo $promo,Prize $prize)
    {
       // $this->middleware(['auth', 'checkRole']);
        $this->pte = $pte;
        $this->promo = $promo;
        $this->prize = $prize;

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
     * Store a newly created promo in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function payment(request $request)
    {

        $validations = $this->customeValidate($request->all());
        if ($validations) {
            return $validations;
        }

        // Start Communicate with database
        DB::beginTransaction();
        try{
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
            $result = $this->pte->payment($request_data);
            dd($result);
            DB::commit();
        } catch (\Exception $e) {
            //exception handling
            DB::rollback();
            $errorMessage = '<a target="_blank" href="https://stackoverflow.com/search?q='.$e->getMessage().'">'.$e->getMessage().'</a>';
            $request->session()->flash('alert-danger', $errorMessage);
            return redirect('/')->withInput();

        }
    /*    if ($addpromo) {
            //Event::fire(new SendMail($addpromo));
            $request->session()->flash('alert-success', __('app.default_add_success',["module" => __('app.voucher')]));
            return redirect('voucher/list');
        } else {
            $request->session()->flash('alert-danger', __('app.default_error',["module" => __('app.voucher'),"action"=>__('app.add')]));
            return redirect('voucher/add')->withInput();
        }*/
    }

    /**
     * Store a newly created promo in storage.
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
            'purpose' => 'FIFA 16',
            'amount' => 2500,
            'phone' => '9999999999',
            'buyer_name' => 'John Doe',
            'redirect_url' => 'http://ptetutorialsonline.com/redirect',
            'send_email' => false,
            'webhook' => 'http://ptetutorialsonline.com/webhook',
            'send_sms' => false,
            'email' => 'foo@example.com',
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($response,true);
        dd($res);

    }

}
