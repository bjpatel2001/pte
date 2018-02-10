@extends('layouts.front.app')

@section('content')

    <div class=banner id=banner>
        <div class=glass>
            <div class="text-center ban-bot">

                <div class=callbacks_container id=top>
                    <div class=row>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col-md-5" hidden-xs hidden-sm>
                            <ul class=rslides id=slider3>
                                <li>
                                    <div class=ban-info><h3>Buy PTE Voucher Online</h3></div>
                                <li>
                                    <div class=ban-info><h3>Get 5 Free PTE Mock Tests</h3></div>
                                <li>
                                    <div class=ban-info><h3>24 X 7 Support</h3></div>
                            </ul>
                        </div>
                        <div class="col-md-5" style="margin-top: 0" ; frm_container>
                            <div class="hidden-xs hidden-sm" style="min-height: 5em;"></div>
                            <form action="{{url('pte/payment-request')}}" name="app_add_form" id="app_form"
                                  style="border-radius: 0px;" method="post"
                                  class="form-horizontal group-border-dashed pte-frm">
                                <h3 style="color:#fff;font-weight:bold;">Limited Time Offer</h3>
                                <h1 style="color:#fff;">Buy PTE Voucher Code for &#8377;{{$rate or ''}} Only</h1>
                                <br>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <select class="form-control" name="state" id="state" required>
                                            <option value="">State</option>
                                            @if(count($state) > 0)
                                                @foreach($state as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        <input type="text" name="name" id="name" placeholder="Name"
                                               class="form-control" value="{{old('name')}}" required/>

                                        <input type="email" name="email" id="email" placeholder="Email"
                                               class="form-control" value="{{old('email')}}" required/>

                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" name="mobile" id="mobile" placeholder="Mobile"
                                               class="form-control" value="{{old('mobile')}}" required/>
                                        <select class="form-control" name="number_of_voucher" id="number_of_voucher"
                                                value="{{old('number_of_voucher')}} required>
                                                <option value=">QTY.No of Discounted PTE Voucher</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                        <br>
                                        <h4 style="color:#fff;font-weight:bold;">Rate : &#8377;{{$rate or ''}}/ Promo Code</h4>

                                        <h5 style="color:#fff;text-align:left;">Code Will Be Sent Out On Your Email
                                            Immediately.</h5>
                                    </div>

                                </div>
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="submit" name="save" class="btn btn-success"
                                                style="border: 1px solid #FFF; background-color: #8dbd35;">Buy PTE Promo
                                            Code
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class=clearfix></div>
            </div>
        </div>
    </div>
    <div class=save-main>
        <div class=container><h2 style=color:#fff;font-weight:700>{{$title or ''}}</h2></div>
    </div>
    <div class="even services-wthree" id=how_to_book>
        <div class=container><h3>How to Book PTE Test Date ?</h3>
            <div class=content-grids>


                <center>
                    <div class="" data-wow-delay=0.1s data-wow-duration=1.5s>
                        <div class=btm-clr4><span>1</span>
                            <center><img alt="Buy PTE Voucher Code" src=https://ptepromocode.com/images/h1.png
                                         style=width:100px;height:100px;margin-top:42px></center>
                            <p>Buy a PROMO Code from <a href=https://www.ptepromocode.com>ptepromocode.com.</a></div>
                        <div class=btm-clr4><span>2</span>
                            <center><img alt="Book PTE Test" src=https://ptepromocode.com/images/h2.png
                                         style=width:100px;height:100px;margin-top:42px></center>
                            <p>Create your ACCOUNT on <a href=http://pearsonpte.com/book>pearsonpte.com/book</a></div>
                        <div class=btm-clr4><span>3</span>
                            <center><img alt="Login in Pearsonpte for PTE exam booking"
                                         src=https://ptepromocode.com/images/h3.png
                                         style=width:100px;height:100px;margin-top:42px></center>
                            <p>Login to <a href=http://pearsonpte.com>pearsonpte.com</a> using your Username and
                                Password
                        </div>
                        <div class=btm-clr4><span>4</span>
                            <center><img alt="Enter details for PTE Test" src=https://ptepromocode.com/images/h4.png
                                         style=width:100px;height:100px;margin-top:42px></center>
                            <p>Enter your preferred date, location and other details</div>
                        <div class=btm-clr4><span>5</span>
                            <center><img alt="Enter PTE Promo or Voucher Code"
                                         src=https://ptepromocode.com/images/h5.png
                                         style=width:100px;height:100px;margin-top:42px></center>
                            <p>Enter Promo Code on the payment page.</div>
                        <div class=btm-clr4><span>6</span>
                            <center><img alt="email from PearsonPTE" src=https://ptepromocode.com/images/h6.png
                                         style=width:100px;height:100px;margin-top:42px></center>
                            <p>Receive CONFIRMATION email from PTE about your test booking.</div>
                    </div>
                </center>


            </div>
        </div>
    </div>
    <div class=services-wthree style=padding-bottom:0><h3>PTE FAQs</h3>
        <div class=container>
            <div class=row>
                <div class=col-md-6>
                    <div id=accordion2><h3 style=color:#fff style=color:#fff>What is PTE-Academic?</h3>
                        <div><p style=text-align:justify>Pearson Test of English Academic Test is a computer based
                                language
                                test of reading, writing, listening and speaking English. The test provides the students
                                with a chance to prove their command over the English language on passing which they
                                would
                                be able to acquire immigration and student visas for themselves.</div>
                        <h3 style=color:#fff style=color:#fff>How PTE Academic exam is different from PTE General?</h3>
                        <div><p style=text-align:justify>Only PTE-A is valid for all visa applications. It must be
                                remembered that PTE-General will not be accepted in case of visa applications.</div>
                        <h3 style=color:#fff>What is the PTE discounted Promo Code?</h3>
                        <div><p style=text-align:justify>It is a payment method in which you will be provided with a PTE
                                discounted voucher or promo code and while booking your PTE test through your official
                                PTE
                                web account you can type in the promo code to access the discount. These codes can be
                                purchased from the professional partners of PTE-Academic. We are one of them.</div>
                        <h3 style=color:#fff>What does <a href=http://www.ptepromocode.com>www.ptepromocode.com</a> do?
                        </h3>
                        <div><p style=text-align:justify>Our website helps the student in booking for PTE Academic Exam
                                at
                                cheap prices, helping them in realizing their dreams of studying abroad. We can also
                                provide
                                the academic and Visa consultation if needed.</div>
                        <h3 style=color:#fff>How do I buy the promo code from PTE Promo Code?</h3>
                        <div><p style=text-align:justify>You need to enter your personal information and select the
                                number
                                of promo codes you want to buy on our website. Then you are needed to enter your credit
                                card
                                information to get the promo code sent to you through e-mail. Our website has a very
                                secure
                                payment gateway and your personal information will be kept safe.</div>
                        <h3 style=color:#fff>How to apply the promo code on to Pearson page?</h3>
                        <div>
                            <ul>
                                <li>You first need to go to the website <a style='color: #27579a;'
                                                                           href=http://www.pearsonpte.com>www.pearsonpte.com</a>
                                    and click on <b>BOOK NOW</b>. Then you need to click on <b>SIGN IN NOW</b>.
                                <li>On the left hand side a column with the option of <b>SCHEDULE NOW</b> will be
                                    visible.
                                <li>Next, you need to choose the nearest 5 centres and click on the <b>SEARCH ICON</b>.
                                <li>Your centre will be displayed here. Then you are required to select month, date and
                                    time-slot
                                <li>Then you need to click on <b>SELECT APPOINTMENT</b>.
                                <li>Then after pressing <b>NEXT</b> you will be able to view the PLT Registration
                                    questions.
                                    Then you need to <b>SCROLL DOWN</b> to view the ‘Add PTE voucher code or promo code’
                                    tab.
                                <li>After typing in the promo code you are required to click on <b>APPLY</b>.
                                <li>Once the code has been applied, the <b>TOTAL DUE</b> amount will be displayed as
                                    0.00.
                                <li>Review your order and click on <b>CHECK BOX</b> to ensure that you have gone through
                                    and
                                    agreed to all the terms and conditions.
                                <li>Next, click on confirm order.
                                <li>After confirmation you will receive a confirmation mail from Pearson.
                            </ul>
                        </div>
                        <h3 style=color:#fff>What is the validity of the promo code to be redeemed on the PTE
                            website?</h3>
                        <div><p style=text-align:justify>The promo code will be effective till 11 months from the date
                                of
                                purchase all over India.</div>
                        <h3 style=color:#fff>Can I book PTE Academic for PR (Migration) and Student Visa?</h3>
                        <div>
                            <ul>
                                <li>In case of Education, all countries accept PTE
                                <li>In case of Migration, presently Australia and NZ are accepting PTE.
                            </ul>
                            <p style=text-align:justify>For further detailed information, please visit <a
                                        href=http://pearsonpte.com/test-takers/accepts>http://pearsonpte.com/test-takers/accepts</a>
                        </div>
                        <h3 style=color:#fff>What is the charge of rescheduling PTE-A?</h3>
                        <div><p style=text-align:justify>Rescheduling takes 25% of the current exam fee in India and
                                your
                                exam can be rescheduled 7 days before the original test date.</div>
                        <h3 style=color:#fff>Which is the best website to buy PTE Promo Code?</h3>
                        <div><p style=text-align:justify>That’s us: <a href=http://ptepromocode.com>ptepromocode.com</a>
                                You
                                can buy the promo code by logging on to this website at point of time.</div>
                    </div>
                </div>
                <div class=col-md-6>
                    <div id=accordion><h3 style=color:#fff>What is the customer care number for PTE in India?</h3>
                        <div><p style=text-align:justify>The TOLL-FREE number in India is 0008004402020. You can call
                                them
                                on weekdays between 9 A.M to 5 P.M.</div>
                        <h3 style=color:#fff>How old do I need to be to take PTE-Academic?</h3>
                        <div><p style=text-align:justify>You should at least be 16 years old to take the test.</div>
                        <h3 style=color:#fff>Do I need to have computer skills to take the test?</h3>
                        <div><p style=text-align:justify>You do not require any special computer skills. However, you
                                are
                                advised to take one of our practice tests or watch the video tutorial on our website to
                                get
                                acquainted with the format.</div>
                        <h3 style=color:#fff>Is it compulsory to appear in the PTE-Academic examination in my home
                            country
                            only?</h3>
                        <div><p style=text-align:justify>No, you can take the test at any of our test centres around the
                                world. However, you are advised to check what type of ID you have to use. If you are
                                away
                                from your home country, you might be asked to show you passport at the test centre.
                        </div>
                        <h3 style=color:#fff>Can I book more than one PTE test?</h3>
                        <div><p style=text-align:justify>You can only book one test at a time.</div>
                        <h3 style=color:#fff>Can I change my exam centre later after buying the PTEpromocode?</h3>
                        <div><p style=text-align:justify>Yes.</div>
                        <h3 style=color:#fff>Are all subjects weighed equally in the exam?</h3>
                        <div><p style=text-align:justify>Yes.</div>
                        <h3 style=color:#fff>How many times can I take the test?</h3>
                        <div><p style=text-align:justify>You can take the test as many times as you want.</div>
                        <h3 style=color:#fff>Can anyone use the promo code which is bought on my name?</h3>
                        <div><p style=text-align:justify>Yes</div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div style=background:#374593;background-size:contain>
            <div class=even style=background:rgba(0,0,0,.6)>
                <div class=container>
                    <div class=row>
                        <div class="col-md-12 testimonials-w3-agileits">
                            <div class=test-content-w3-agile><h3>Testimonials</h3>
                                <div class="example1 wmuSlider" style=max-height:150px>
                                    <div class=wmuSliderWrapper>
                                        <article style=position:relative;width:100%;opacity:1>
                                            <div class=banner-wrap><p><i aria-hidden=true class="fa fa-quote-left"></i>
                                                    PTEPromoCode helped me to save Money and it also provided me with a
                                                    mock
                                                    test. The staff are good and are responding to the queries
                                                    immediately.
                                                    <i aria-hidden=true class="fa fa-quote-right"></i><h4>-Shital
                                                    Sharma</h4></div>
                                        </article>
                                        <article style=position:relative;width:100%;opacity:1>
                                            <div class=banner-wrap><p><i aria-hidden=true class="fa fa-quote-left"></i>
                                                    Nice
                                                    deal,got good PTE Exam discount on PTEPromoCode + also got tests for
                                                    practice + awesome customer service. <i aria-hidden=true
                                                                                            class="fa fa-quote-right"></i>
                                                <h4>-Gaurang Kadia</h4></div>
                                        </article>
                                        <article style=position:relative;width:100%;opacity:1>
                                            <div class=banner-wrap><p><i aria-hidden=true class="fa fa-quote-left"></i>
                                                    Thank you PTEPromoCode team saving and serving best way. I like the
                                                    way
                                                    you serve and treat your clients. Good job and keep rocking <i
                                                            aria-hidden=true class="fa fa-quote-right"></i><h4>-Srishti
                                                    Vasekar</h4></div>
                                        </article>
                                        <article style=position:relative;width:100%;opacity:1>
                                            <div class=banner-wrap><p><i aria-hidden=true class="fa fa-quote-left"></i>
                                                    Highly recommended and the mock tests are quite helpful in preparing
                                                    for
                                                    PTE exams, Very Helpful people out there Thanks PTEPromoCode <i
                                                            aria-hidden=true class="fa fa-quote-right"></i><h4>-Ronak
                                                    Patel</h4></div>
                                        </article>
                                    </div>
                                    <ul class=wmuSliderPagination>
                                        <li><a href=# class=wmuActive>0</a>
                                        <li><a href=#>1</a>
                                        <li><a href=#>2</a>
                                    </ul>
                                </div>
                                <script src="{{ asset('css/front/js/jquery.wmuSlider.js') }}"></script>
                                <script>$(".example1").wmuSlider()</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
