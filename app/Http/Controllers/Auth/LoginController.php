<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Models\State;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Override login athentication method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */

    public function login(Request $request)
    {

        $this->validate($request, ['email' => 'required', 'password' => 'required'] );

        $remember = false;
        if($request->remember == '1'){
            $remember = true;
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,'status' => 1],$remember)) {

            $request->session()->flash('alert-success', trans('app.user_login_success'));
            return redirect('dashboard');
        }else{
            $request->session()->flash('alert-danger', trans('app.user_login_error'));
            return redirect('login')->withInput($request->except('password'));
        }
    }

    /**
     * Index front page
     *
     * @return view
     */
    public function welcome()
    {
        $state_model = new State();
        $data['state'] = $state_model->getCollection();
        return view('front.index',$data);
    }

    public function howToBook()
    {
        return view('front.how_to_book');
    }

    public function pteFaq()
    {
        return view('front.pte_faq');
    }

    public function refundPolicy()
    {
        return view('front.refund_policy');
    }

    public function contactUs()
    {
        return view('front.contact_us');
    }

}
