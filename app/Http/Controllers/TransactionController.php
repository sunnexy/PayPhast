<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transaction;
use \BenMajor\ExchangeRatesAPI\ExchangeRatesAPI;
use \BenMajor\ExchangeRatesAPI\Response;
use \BenMajor\ExchangeRatesAPI\Exception;

class TransactionController extends Controller
{
    public function transactions()
    {
        if(Auth::check()){
            $access_key = 'f55a0cc91e5cfc4e8b695f41b5ec9d2d';
            $use_ssl = false; # Free plans are restricted to non-SSL only.
            
            $exapi = new ExchangeRatesAPI($access_key, $use_ssl);
            $rates  = $exapi->fetch();
            $convertUSD = $rates->getrates()["USD"];
            $convertEUR = $rates->getrates()["EUR"];
            $convertGBP = $rates->getrates()["GBP"];
            $user = Auth::user();
            $transactions = Transaction::where('sender', $user->name)->orWhere('receiver', $user->name)->get();
            return view('transactions', ['convertUSD'=>$convertUSD, 'user' => $user, 'transactions' => $transactions]);
        }
        return view('login');
    }

    public function create()
    {
        if(Auth::check()){
            $users = User::all()->except(Auth::id());;
            $user = Auth::user();
            return view('create', ['users' => $users, 'user' => $user]);
        }
        return view('login');
    }

    public function transfer(Request $request)
    {
        if(Auth::check()){
            $url = 'https://api.exchangerate-api.com/v4/latest/USD';
            $json = file_get_contents($url);
            $exp = json_decode($json);

            // $convertUSD = $exp->rates->USD;
            // $convertEUR = $exp->rates->EUR;
            // $convertGBP = $exp->rates->GBP;

            // $endpoint = 'USD';
            // $access_key = 'f55a0cc91e5cfc4e8b695f41b5ec9d2d';

            // Initialize CURL:
            $access_key = 'f55a0cc91e5cfc4e8b695f41b5ec9d2d';
            $use_ssl = false; # Free plans are restricted to non-SSL only.
            
            $exapi = new ExchangeRatesAPI($access_key, $use_ssl);
            $rates  = $exapi->fetch();
            $convertUSD = $rates->getrates()["USD"];
            $convertEUR = $rates->getrates()["EUR"];
            $convertGBP = $rates->getrates()["GBP"];

            $user = Auth::user();
            $usdbalance = $user->usd_balance;
            $this->validate($request, [
                'source' => 'required',
                'receiver' => 'required',
                'amount' => 'required|integer',
                'currency' => 'required'
            ]);
            $source = $request->source;
            $sender = Auth::user()->name;
            $receiver = $request->receiver;
            $amount = $request->amount;
            $currency = $request->currency;

            $receiver_bal = User::where('name', $receiver)->first();
            if($source == "USD"){
                if($currency == "USD"){
                    if($amount <= $usdbalance){
                        $bal = $usdbalance - $amount;
    
                        $receiver_usd = $receiver_bal->usd_balance; 
                        $balance = $receiver_usd + $amount;
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertUSD,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['usd_balance' => $balance]);
                        User::where('name', $sender)->update(['usd_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertUSD,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }elseif($currency == "EUR"){
                    if($amount <= $usdbalance){
                        $amountEUR = $convertEUR * $amount;

                        $bal = $usdbalance - $amount;
                        $receiver_eur = $receiver_bal->eur_balance;
                        $balance = $receiver_eur + $amountEUR;
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertEUR,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['eur_balance' => $balance]);
                        User::where('name', $sender)->update(['usd_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertEUR,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }elseif($currency == "GBP"){
                    if($amount <= $usdbalance){
                        $amountGBP = $convertGBP * $amount;
    
                        $bal = $usdbalance - $amount;
                        $receiver_gbp = $receiver_bal->gbp_balance; 
                        $balance = $receiver_gbp + $amountGBP;
                        
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertGBP,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['gbp_balance' => $balance]);
                        User::where('name', $sender)->update(['usd_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertGBP,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }
            }elseif($source == "EUR"){
                $access_key = 'f55a0cc91e5cfc4e8b695f41b5ec9d2d';
                $use_ssl = false; # Free plans are restricted to non-SSL only.
                
                $exapi = new ExchangeRatesAPI($access_key, $use_ssl);
                $rates  = $exapi->fetch();
                $convertUSD = $rates->getrates()["USD"];
                $convertEUR = $rates->getrates()["EUR"];
                $convertGBP = $rates->getrates()["GBP"];

                $eurbalance = $user->eur_balance;
                $receiver_bal = User::where('name', $receiver)->first();
                if($currency == "USD"){
                    if($amount <= $eurbalance){

                        $amountUSD = $convertUSD * $amount;
                        $bal = $eurbalance - $amount;
    
                        $receiver_usd = $receiver_bal->usd_balance; 
                        $balance = $receiver_usd + $amountUSD;
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertUSD,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['usd_balance' => $balance]);
                        User::where('name', $sender)->update(['eur_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertUSD,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }elseif($currency == "EUR"){
                    if($amount <= $eurbalance){
                        $amountEUR = $convertEUR * $amount;
    
                        $bal = $eurbalance - $amount;
                        $receiver_eur = $receiver_bal->eur_balance;
                        $balance = $receiver_eur + $amountEUR;
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertEUR,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['eur_balance' => $balance]);
                        User::where('name', $sender)->update(['usd_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertEUR,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }elseif($currency == "GBP"){
                    if($amount <= $eurbalance){
                        $amountGBP = $convertGBP * $amount;
    
                        $bal = $eurbalance - $amount;
                        $receiver_gbp = $receiver_bal->gbp_balance; 
                        $balance = $receiver_gbp + $amountGBP;
                        
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertGBP,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['gbp_balance' => $balance]);
                        User::where('name', $sender)->update(['usd_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertGBP,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }
            }elseif($source == "GBP"){
                $url = 'https://api.exchangerate-api.com/v4/latest/GBP';
                $json = file_get_contents($url);
                $exp = json_decode($json);

                $convertUSD = $exp->rates->USD;
                $convertEUR = $exp->rates->EUR;
                $convertGBP = $exp->rates->GBP;

                $gbpbalance = $user->gbp_balance;
                $receiver_bal = User::where('name', $receiver)->first();
                if($currency == "USD"){
                    if($amount <= $gbpbalance){
                        $amountUSD = $convertUSD * $amount;
                        $bal = $gbpbalance - $amount;
    
                        $receiver_usd = $receiver_bal->usd_balance; 
                        $balance = $receiver_usd + $amountUSD;
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertUSD,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['usd_balance' => $balance]);
                        User::where('name', $sender)->update(['gbp_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertUSD,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }elseif($currency == "EUR"){
                    if($amount <= $gbpbalance){
                        $amountEUR = $convertEUR * $amount;
    
                        $bal = $gbpbalance - $amount;
                        $receiver_eur = $receiver_bal->eur_balance;
                        $balance = $receiver_eur + $amountEUR;
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertEUR,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['eur_balance' => $balance]);
                        User::where('name', $sender)->update(['gbp_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertEUR,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }elseif($currency == "GBP"){
                    if($amount <= $gbpbalance){
                        $amountGBP = $convertGBP * $amount;
    
                        $bal = $gbpbalance - $amount;
                        $receiver_gbp = $receiver_bal->gbp_balance; 
                        $balance = $receiver_gbp + $amountGBP;
                        
                        $transaction = Transaction::create([
                            'source_currency' => $request->source,
                            'sender' => $sender,
                            'receiver' => $receiver,
                            'amount' => $amount,
                            'target_currency' => $currency,
                            'exchange_rate' => $convertGBP,
                            'status' => 'successful'
                        ]);
                        User::where('name', $receiver)->update(['gbp_balance' => $balance]);
                        User::where('name', $sender)->update(['gbp_balance' => $bal]);
    
                        return redirect('/transactions')->with('success', 'Money sent successfully');
                    }
                    $transaction = Transaction::create([
                        'source_currency' => $request->source,
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'amount' => $amount,
                        'target_currency' => $currency,
                        'exchange_rate' => $convertGBP,
                        'status' => 'failed'
                    ]);
                    return redirect()->back()->with('danger', 'Not enough funds!');
                }
            }
        }
        return view('login');
    }
}
