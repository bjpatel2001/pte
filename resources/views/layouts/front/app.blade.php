<!DOCTYPE html>
<html lang=en><title>Buy PTE Voucher @ ₹ Only + Free Mock Tests</title>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-101966658-1', 'auto');
    ga('send', 'pageview');

</script>

<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5L5SL7V');</script>
<!-- End Google Tag Manager -->
<head>
    <script src="{{ asset('slider/sliderengine/jquery.js') }}"></script>
    <script src="{{ asset('slider/sliderengine/amazingslider.js') }}"></script>
    <link rel="stylesheet" href="{{url('slider/sliderengine/amazingslider-1.css')}}" type="text/css" />
    <script src="{{ asset('slider/sliderengine/initslider-1.js') }}"></script>

</head>
<meta content="Want to book PTE Academic Exam online? Buy PTE Voucher online at ₹ and get free mock test. Get your voucher/promo code and free mock test instantly."
      name=description>
<meta content="width=device-width,initial-scale=1" name=viewport>
<meta content="text/html; charset=utf-8" http-equiv=Content-Type>
<link rel="shortcut icon" type="image/x-icon" href="{!! asset('css/front/images/favicon.png') !!}">


<link rel="stylesheet" href="{{url('css/front/css/bootstrap.css')}}" type="text/css" />
<link rel="stylesheet" href="{{url('css/front/css/style.css')}}" type="text/css" />
<link rel="stylesheet" href="{{url('css/front/css/anim.css')}}" type="text/css" />
<link rel="stylesheet" href="{{url('css/front/css/font-awesome.min.css')}}" type="text/css" />

<link href="//fonts.googleapis.com/css?family=Arima+Madurai" rel=stylesheet>
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic"
      rel=stylesheet>
{{--<script src="{{url('js/plugins/jquery.min.js')}}" type="text/javascript"></script>--}}
<script src="{{url('js/plugins/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{url('css/front/js/move-top.js')}}"></script>
<script src="{{url('css/front/js/easing.js')}}"></script>

<script src="{{ asset('css/front/js/responsiveslides.min.js') }}"></script>
<script async>$(function () {
        $("#slider3").responsiveSlides({
            auto: !0,
            pager: !0,
            nav: !1,
            speed: 500,
            namespace: "callbacks",
            before: function () {
                $(".events").append("<li>before event fired.</li>")
            },
            after: function () {
                $(".events").append("<li>after event fired.</li>")
            }
        })
    })</script>

<script async>jQuery(document).ready(function (t) {
        t(".scroll").click(function (e) {
            e.preventDefault(), t("html,body").animate({scrollTop: t(this.hash).offset().top}, 1e3)
        })
    })</script>
<script async>$(document).ready(function () {
        $().UItoTop({easingType: "easeOutQuart"})
    })</script>
<link rel="stylesheet" href="{{url('css/front/ui/jquery-ui.css')}}" type="text/css" />
<script src="{{ asset('css/front/ui/jquery-ui.js') }}"></script>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>

<body>

@include('layouts.front.header')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}" style="text-align:center;">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
</div>
@yield('content')
@include('layouts.front.footer')

<!-- Scripts -->
<script src="{{ asset('css/front/js/bars.js') }}"></script>


<script src="{{ asset('css/front/js/smoothbox.jquery2.js') }}"></script>

@stack('external_script')
@stack('script')

</body>
</html>
