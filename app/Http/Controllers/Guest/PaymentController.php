<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function index(){
        $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey'),
        ]);

        $token = $gateway->ClientToken()->generate(); 
    
        return view('guests.hosted', compact('token'));
    }

    public function checkout(Request $request){
        // Creazione di una validation?

        $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey'),
        ]); 
        
        $amount = $request->amount;
        $nonce = $request->payment_method_nonce;
    
        $result = $gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
    
        // if ($result->success || !is_null($result->transaction))
        if ($result->success) {
            $transaction = $result->transaction;
            
            // Creazione di un nuovo ordine con i dati inseriti dall'utente
            $newOrder = new Order();
            $newOrder->fill($request->all());
            $newOrder->save();
            
            // Recupero del carrello dal localStorage, sottoforma di array associativo
            $cart = json_decode($request->infoCart, true);
            // Suddivisione di ogni piatto del menu
            $listDishesOrdered = array_slice($cart['menu'], 0);
            
            // Collegamento dell'ordine con i piatti aquistati
            foreach($listDishesOrdered as $order)
            {
                $newOrder->dishes()->attach([$order['id'] => ['quantity' => $order['quantity']]]);
            }
            
            return redirect()->route('payment.success')->with('success_message', 'Transaction successful. The ID is: '. $transaction->id);
        } else {
            $errorString = "";
    
            foreach($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }
            
            return redirect()->route('payment.success')->with('success_message', 'Transaction successful. The ID is: '. $result->message);
        }
    }

    public function done() {
        return view('guests.success');
    }
}
