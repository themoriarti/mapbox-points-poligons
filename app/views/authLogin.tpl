<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>Login Page</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
  ================================================== -->


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
    @import url(//fonts.googleapis.com/css?family=Roboto:100);
    @import url(//cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.css);

    body {
      background: #1a1a1a;
      color: white;
      font-family: 'Roboto';
    }
    .flat-form {
      background: #e74c3c;
      margin: 25px auto;
      width: 390px;
      /*height: 340px;*/
      padding: 25px;
      margin-top: 50px;
      position: relative;
      font-family: 'Roboto';
    }
    .flat-form #login {

    }
    .form-action {
      padding: 0 20px;
      position: relative;
    }

    .form-action h1 {
      font-size: 42px;
      padding-bottom: 10px;
    }
    .form-action p {
      font-size: 12px;
      padding-bottom: 10px;
      line-height: 25px;
    }
    form {
      padding-right: 20px !important;
    }
    form input[type=text],
    form input[type=password],
    form input[type=submit] {
      font-family: 'Roboto';
    }

    form input[type=text],
    form input[type=password] {
      width: 100%;
      height: 40px;
      margin-bottom: 10px;
      padding-left: 15px;
      background: #fff;
      border: none;
      color: #e74c3c;
      outline: none;
    }

    .dark-box {
      background: #5e0400;
      box-shadow: 1px 3px 3px #3d0100 inset;
      height: 40px;
      width: 50px;
    }
    .form-action .dark-box.bottom {
      position: absolute;
      right: 0;
      bottom: -24px;
    }
    .tabs + .dark-box.top {
      position: absolute;
      right: 0;
      top: 0px;
    }
    .button {
        border: none;
        display: block;
        background: #136899;
        height: 40px;
        width: 80px;
        color: #ffffff;
        text-align: center;
        border-radius: 5px;
        /*box-shadow: 0px 3px 1px #2075aa;*/
          -webkit-transition: all 0.15s linear;
          -moz-transition: all 0.15s linear;
          transition: all 0.15s linear;
    }

    .button:hover {
      background: #1e75aa;
      /*box-shadow: 0 3px 1px #237bb2;*/
    }

    .button:active {
      background: #136899;
      /*box-shadow: 0 3px 1px #0f608c;*/
    }

    ::-webkit-input-placeholder {
      color: #e74c3c;
    }
    :-moz-placeholder {
      /* Firefox 18- */
      color: #e74c3c;
    }
    ::-moz-placeholder {
      /* Firefox 19+ */
      color: #e74c3c;
    }
    :-ms-input-placeholder {
      color: #e74c3c;
    }
    </style>
</head>
<body>

    <div class="container">
        <div class="flat-form">
            <div id="login" class="form-action show">
                <h1>Login on webapp</h1>
                <p>
                    Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
                    Maecenas sed diam eget risus varius bladit sit amet non
                </p>
                <form>
                    <ul>
                        <li>
                            <input type="text" placeholder="Username" />
                        </li>
                        <li>
                            <input type="password" placeholder="Password" />
                        </li>
                        <li>
                            <input type="submit" value="Login" class="button" />
                        </li>
                    </ul>
                </form>
            </div>
            <!--/#login.form-action-->
        </div>
    </div>
    <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
</body>
</html>
