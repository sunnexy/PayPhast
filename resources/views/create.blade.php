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
    <div style="margin-top: 130px; padding: 10px; border: 1px solid black;">
          <div class="col-xl-7 col-lg-7 col-md-7">
              @include('partials.errors')
              @include('partials.success')
              @if (session('danger'))
              <div class="alert alert-danger" style="font-size: 18px;">
                  <button class="close" style="width:50px;" type="button" data-dismiss="alert" aria-hidden="true"></button>
                  {{ session('danger') }}
              </div>
              @endif
              <a style="font-size: 24px; color: blue; float: right;" href="{{URL('transactions')}}">back</a>
              <div class="last-step">
              <form action="{{ URL('transfer') }}" method="POST">
                {{ csrf_field() }}
                <div class="mb-4">
                      <div class="input-group">
                          <select class="form-select form-control-lg" name="source" id="crypto-buy-to">
                              <option disabled selected="">Select Account</option>
                              <option value="USD">USD account</option>
                              <option value="EUR">EUR account</option>
                              <option value="GBP">GBP account</option>
                          </select>
                      </div>
                  </div>
                  <div class="mb-4">
                      <div class="input-group">
                          <select class="form-select form-control-lg" name="receiver" id="crypto-buy-to">
                              <option disabled selected="">Select Receiver</option>
                              @foreach($users as $user)
                                  <option value="{{$user->name}}">{{$user->name}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="">Amount USD</label>
                      <input type="number" class="form-control" name="amount" placeholder="Amount ($)">
                  </div><br>
                  <div class="mb-4">
                    <label class="form-label" for="crypto-buy-to">Select Currency</label>
                      <div class="input-group">
                        <select class="form-select form-control-lg" id="crypto-buy-to" name="currency">
                          <option value="USD">USD</option>
                          <option value="EUR">EUR</option>
                          <option value="GBP">GBP</option>
                        </select>
                      </div>
                  </div>
                  <div class="mb-4">
                      <button style="background-color: blue; color: black;" type="submit" class="btn btn-lg w-100 btn-alt-primary">Transfer</button>
                  </div>
                </form>
              </div>        
          </div>
      </div>
</body>
</html>