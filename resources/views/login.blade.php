
<!DOCTYPE html>
<html lang="en">

<head>
    @include('include.head')
</head>

<body>
    <!--========== Preloader ==========-->
    
    <!--========== Preloader ==========-->

    
    <!-- ============Header Section Starts Here================== -->
    <header class="header-section" style="background-color: blue; height: 120px; margin-top: -60px; margin-bottom: 30px;">
        <div class="container" style="font-size: 38px; margin-top: 40px; color: white; text-align: center;">
            Send-Wise
        </div>
    </header>
    <!-- ============Header Section Ends Here================== -->

    <!--=======Account-Section Starts Here=======-->
    <section class="account-section padding-top padding-bottom">
        <div class="container">
            <div class="tab account-tab">
                <ul class="tab-menu">
                    <a href="{{ URL('signup') }}"><li class="tab-out"><span>sign up</span></li></a>
                    <li class="active tab-in"><span>sign in</span></li>
                </ul>
                <div class="tab-area">
                    <div class="tab-item">
                        <form class="row account-form justify-content-center">
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="text" placeholder="First Name" name="name">
                            </div>
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="text" placeholder="Last Name" name="name">
                            </div>
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="text" placeholder="Phone" name="phone">
                            </div>
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="text" placeholder="Email" name="email">
                            </div>
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="password" name="pasword" placeholder="Password">
                            </div>
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <input type="password" name="pasword" placeholder="Confirm Password">
                            </div>
                            <div class="form-group col-sm-10 col-lg-5 col-xl-4">
                                <input type="checkbox" id="check01">
                                <label for="check01">I agree to the <a href="#0">Terms, Privacy policy and fees</a></label>
                            </div>
                            <div class="form-group col-sm-10 col-lg-3 col-xl-4">
                                <input type="submit" value="sign up">
                            </div>
                            <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                <p>Already have an account ? <a href="sign-in.html">Sign In</a></p>
                            </div>
                        </form>
                        <span class="sign-in-option text-center d-block">
                            or user social media to sign in
                        </span>
                    </div>
                    <div class="tab-item active">
                        <div class="row">
                            <div class="col-lg-6 d-lg-block d-none">
                                <div class="tab-thumb">
                                    <img src="{{ asset('images/account.png') }}" alt="account">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <form class="row account-form sign-in-form" method="post" action="{{URL('login')}}">
                                {{ csrf_field() }}
                                    <div class="form-group col-12">
                                        <input type="text" placeholder="Email" name="email">
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <input type="submit" value="sign in">
                                    </div>
                                    <div class="form-group col-sm-10 col-lg-4 col-md-6">
                                      <p>Dont have an account yet? <a href="{{URL('/signup')}}">Sign Up</a></p>
                                  </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=======Account-Section Ends Here=======-->
  @include('include.footer')
</body>

</html>