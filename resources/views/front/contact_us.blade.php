@extends('layouts.front.app')

@section('content')

    <div class=hd>
        <div class=glass2 style=background:rgba(0,0,0,.6)><h1>Contact Us</h1></div>
    </div>
    <div class=container style="padding:80px 0">
        <div class=row>
            <div class=col-md-1></div>
            <div class=col-md-6 style=padding:40px>

                <form action="{{url('send-query')}}" name="app_add_form" id="app_form"  method="post" >
                    <h2>Send Message</h2><br>
                    <input class=form-control name="name" placeholder="Enter Your Name" required><br>
                    <div class=row>
                        <div class=col-md-6><input class=form-control name=email placeholder="Enter Your E-mail"
                                                   required type=email></div>
                        <div class="visible-xs"><br></div>
                        <div class=col-md-6><input class=form-control name=mobile placeholder="Enter Your Contact No"
                                                   required></div>
                    </div>
                    <input type="hidden" name="type" value="send_query">
                    <br><textarea class=form-control name=message placeholder="Enter Message" rows=5></textarea><br>
                    <button class="btn btn-success" style='float:right;' type=submit><i
                                class="glyphicon glyphicon-send"></i> Send Message
                    </button>
                    {{ csrf_field() }}
                </form>
                <div style=clear:both;min-height:20px></div>
            </div>
            <div class=col-md-5 style=padding:40px><h1>Contact Details</h1><br>
                <table class=table>
                    <tr>
                        <th>E-mail
                        <td>info@ptevouchercode.com
                    <tr>
                        <th style=min-width:100px>Contact No.
                        <td>+91-9687646863
                    <tr>
                        <th style=min-width:100px>
                        <td>+91-9687646861
                    <tr>
                        <th>Address
                        <td>B-120, Balaji Industries Society, Part-2, Opp. Surya Plaza, Near Arancia Kuchen, Bhatar,
                            Surat - 395002 (Gujarat) INDIA.
                    <tr>
                        <th>
                        <td>
                </table>
            </div>
        </div>
    </div>
    <div></div>
@endsection
