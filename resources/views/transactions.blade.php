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
        <a href="{{URL('logout')}}" style="float:right;"><button style="width: 100px; margin-right:10px; font-size:18px; background-color:white;">Logout</button></a>
    </header>
    <div class="user-dashboard" style="margin-top: 150px; padding: 20px; border: 1px solid black;">
      <div class="container">
          <div class="transactions-table">
              <div class="table-responsive">
                  <main id="main-container">
                    <div class="content">
                      <div style="text-align: center;">
                        <button style="background-color: blue; color: white; width: 100px;">{{$user->usd_balance}} USD</button>
                        <button style="background-color: blue; color: white; width: 100px;">{{$user->eur_balance}} EUR</button>
                        <button style="background-color: blue; color: white; width: 100px;">{{$user->gbp_balance}} GBP</button>
                      </div>
                      <h2 class="content-heading">Transactions</h2>
                      <form method="get" action="{{URL('create')}}" style="float: right; color: blue; width: 200px; margin: 20px;"><input type="submit" value="NEW TRANSACTION" /></form>
                      <div class="block block-rounded">
                        <div class="block-header block-header-default">
                        </div>
                        <div class="block-content block-content-full">
                          <div style="text-align: center;">
                            @include('partials.success')
                          </div>
                          <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                              <tr>
                                <th class="text-center" style="font-size: 12px; width: 5%;">ID</th>
                                <th class="text-center" style="font-size: 12px; width: 15%;">From</th>
                                <th class="text-center" style="font-size: 12px; width: 15%;">To</th>
                                <th class="text-center">Amount Sent</th>
                                <th class="text-center">Amount Received</th>
                                <th class="text-center">Exchange Rate</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="font-size: 14px; width: 15%;">Created At</th>
                                <th class="text-center" style="font-size: 14px; width: 15%;">Updated At</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                              <tr>
                                <td class="text-center">{{$transaction->id}}</td>
                                @if($transaction->sender == $user->name)
                                <td class="text-center">You</td>
                                @else
                                <td class="text-center">{{$transaction->sender}}</td>
                                @endif
                                @if($transaction->receiver == $user->name)
                                <td class="text-center">You</td>
                                @else
                                <td class="text-center">{{$transaction->receiver}}</td>
                                @endif
                                <td class="text-center">{{$transaction->amount}} {{$transaction->source_currency}}</td>
                                <td class="text-center">{{$transaction->amount * $transaction->exchange_rate}} {{$transaction->target_currency}}</td>
                                <td class="text-center">{{$transaction->exchange_rate}}</td>
                                @if($transaction->status == 'failed')
                                <td class="text-center"><i style="color:red; font-size:14px;">{{$transaction->status}}</i></td>
                                @else
                                <td class="text-center"><b style="color:green; font-size:14px;">{{$transaction->status}}</b></td>
                                @endif
                                <td class="text-center">{{$transaction->created_at->format(F j, Y G:i)}}</td>
                                <td class="text-center">{{$transaction->updated_at}}</td>
                              </tr>
                            @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </main>
                </div>
            </div>
          </div>
        </div>
    </body>

</html>