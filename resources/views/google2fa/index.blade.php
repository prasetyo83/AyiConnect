<!DOCTYPE html><!--  This site was created in Webflow. http://www.webflow.com  -->
<!--  Last Published: Mon May 30 2022 08:00:18 GMT+0000 (Coordinated Universal Time)  -->
<html data-wf-page="629219354ef7445020ef9bd5" data-wf-site="628e232b6202d8e68069e187">

<head>
    <meta charset="utf-8">
    <title>LOGIN</title>
    <meta content="LOGIN" property="og:title">
    <meta content="LOGIN" property="twitter:title">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">
    <link href="css/normalize.css" rel="stylesheet" type="text/css">
    <link href="css/webflow.css" rel="stylesheet" type="text/css">
    <link href="css/thegoodquote-dashboard.webflow.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Poppins:100,200,300,regular,500,600,700,800,900"]
            }
        });
    </script>
    <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
    <script type="text/javascript">
        ! function(o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
                .className += t + "touch")
        }(window, document);
    </script>
    <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="images/webclip.png" rel="apple-touch-icon">
    <style>
        img{
            width:160px;
            height:auto;
        }        
    </style>
</head>

<body class="body-16">
    <div class="div-block-3">
        <div class="logo-holder"><img src="images/splashLogo.png" loading="lazy" width="295"
                sizes="(max-width: 479px) 100vw, 295px"
                srcset="images/splashLogo-p-500.png 500w, images/splashLogo-p-800.png 800w, images/splashLogo-p-1080.png 1080w, images/splashLogo.png 1280w"
                alt="" class="image"></div>
        <div class="login-container">
            <div class="w-form">
                <form id="wf-form-Login-form" name="wf-form-Login-form" data-name="Login form" method="POST"
                    action="{{ route('2fa') }}" class="form-2">
                    @csrf
                    <label for="name" class="nentitujt">One Time Password</label>
                    <input id="one_time_password" type="number" class="w-input form-control" name="one_time_password" required autofocus>
                   <input type="submit" value="Sign In" data-wait="Please wait..."
                        class="button-3 w-button">

                </form>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                {{-- @foreach($hasheds as $hashed) --}}
             
                {{-- @endforeach --}}
                <div class="w-form-done">
                    <div>Thank you! Your submission has been received!</div>
                </div>
                <div class="w-form-fail">
                    <div>Oops! Something went wrong while submitting the form.</div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=628e232b6202d8e68069e187"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script src="js/webflow.js" type="text/javascript"></script>
    <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
</body>

</html>
