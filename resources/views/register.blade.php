
<!DOCTYPE html>
<html lang="en">

<head>
   @include('include.head')
</head>

<body>
    <a href="#0" class="scrollToTop"><i class="fas fa-angle-up"></i></a>
    <div class="overlay"></div>
    <!--========== Preloader ==========-->

    
    <!-- ============Header Section Starts Here================== -->
    <header class="header-section" style="background-color: blue; height: 120px; margin-top: -60px; margin-bottom: 30px;">
        <div class="container" style="font-size: 38px; margin-top: 40px; color: white; text-align: center;">
            PayPhast
        </div>
    </header>
    <!-- ============Header Section Ends Here================== -->

    <!--=======Account-Section Starts Here=======-->
    <section class="account-section padding-top padding-bottom">
        <!-- <div class="trigon-5">
            <img src="./assets/css/img/trigon09.png" alt="css">
        </div>
        <div class="anime-1">
            <img src="./assets/images/animation/01.png" alt="animation">
        </div>
        <div class="anime-2">
            <img src="./assets/images/animation/02.png" alt="animation">
        </div>
        <div class="anime-3">
            <img src="./assets/images/animation/03.png" alt="animation">
        </div>
        <div class="anime-4">
            <img src="./assets/images/animation/04.png" alt="animation">
        </div>
        <div class="anime-5">
            <img src="./assets/images/animation/05.png" alt="animation">
        </div> -->
        <div class="container">
            <div class="tab account-tab">
                <ul class="tab-menu">
                    <li class="active tab-out"><span>sign up</span></li>
                    <a href="{{URL('/')}}"><li class="tab-in"><span>sign in</span></li></a>
                </ul>
                <div class="tab-area">
                    <div class="tab-item active">
                        <form class="row account-form justify-content-center" method="POST" action="{{URL('register')}}">
                        {{ csrf_field() }}
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="text" placeholder="Name" name="name">
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block m-b-none small text-danger">
                                <strong style="color: red;">{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="text" placeholder="Email" name="email">
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block m-b-none small text-danger">
                                <strong style="color: red;">{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="password" name="password" placeholder="Password">
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block m-b-none small text-danger">
                                <strong style="color: red;">{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                            <div class="form-group col-sm-10 col-lg-3 col-xl-4">
                                <input type="submit" value="sign up">
                            </div>
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <p>Already have an account ? <a href="{{URL('/')}}">Sign In</a></p>
                            </div>
                        </form>
                    </div>
                    <div class="tab-item">
                        <div class="row">
                            <div class="col-lg-6 d-lg-block d-none">
                                <div class="tab-thumb">
                                    <img src="./assets/images/account/account.png" alt="account">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <form class="row account-form sign-in-form">
                                    <div class="form-group col-12">
                                        <input type="text" placeholder="Username of Email" name="email">
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="password" name="pasword" placeholder="Password">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <input type="submit" value="sign in">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <input type="checkbox" id="check02">
                                        <label for="check02">keep me in</label>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <p><a href="#0">Forget Password</a></p>
                                    </div>
                                </form>
                                <span class="sign-in-option text-sm-left text-center d-block">
                                    or user social media to sign in
                                </span>
                                <ul class="social-sign-in justify-content-sm-start">
                                    <li>
                                        <a href="#0" class="facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#0" class="twitter active">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#0" class="linkedin">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======Account-Section Ends Here=======-->


    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="./assets/js/jquery-3.3.1.min.js"></script>
    <script src="./assets/js/modernizr-3.6.0.min.js"></script>
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/isotope.pkgd.min.js"></script>
    <script src="./assets/js/magnific-popup.min.js"></script>
    <script src="./assets/js/swiper.min.js"></script>
    <script src="./assets/js/wow.min.js"></script>
    <script src="./assets/js/odometer.min.js"></script>
    <script src="./assets/js/viewport.jquery.js"></script>
    <script src="./assets/js/nice-select.js"></script>
    <script src="./assets/js/paroller.js"></script>
    <script src="./assets/js/main.js"></script>
</body>

</html>