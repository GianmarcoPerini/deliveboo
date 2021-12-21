@extends('layouts.app')

@section('content')
    <style>
            #card-number, #cvv, #expiration-date {
                background: white;
                height: 38px;
                border: 1px solid #CED4DA;
                padding: .375rem .75rem;
                border-radius: .25rem;
            }
    </style>
    <div class="container">
        <form method="post" action="{{ route('payment.checkout') }}" class="row g-3" id="my-sample-form">
            @csrf
            <div class="col-md-4">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="col-md-4">
                <label for="surname" class="form-label">Cognome</label>
                <input type="text" class="form-control" id="surname" name="surname">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Contatto</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="col-md-7">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Indirizzo di consegna">
            </div>
            <div class="col-md-3">
                <label for="city" class="form-label">Citt&aacute;</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Citt&aacute;">
            </div>
            <div class="col-md-2">
                <label for="zip_code" class="form-label">CAP</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code">
            </div>

            <div class="col-md-3">
                <label for="amount" class="form-label">Totale da pagere</label>
                <input id="amount" name="amount" type="hidden"/>                
                <div class="form-control" id="amountTag"></div>
            </div>

            <div class="offset-9"></div>

            <div class="col-md-4">
                <label for="card-number">Card Number</label>
                <div id="card-number"></div>
            </div>

            <div class="col-md-4">    
                <label for="cvv">CVV</label>
                <div id="cvv"></div>
            </div>

            <div class="col-md-4">
                <label for="expiration-date">Expiration Date</label>
                <div id="expiration-date"></div>
            </div>
            
            <div class="col-md-12 mt-3">
                
                <input id="infoCart" name="infoCart" type="hidden" />
                <input id="nonce" name="payment_method_nonce" type="hidden" />
                <button id="btn-confirm" type="submit" class="btn btn-primary">Conferma</button>
            </div>
        </form>
    </div>
    
@endsection

@section('script')
    <script src="https://js.braintreegateway.com/web/3.84.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.84.0/js/hosted-fields.min.js"></script>
        <script>
        var form = document.querySelector('#my-sample-form');
        var submit = document.querySelector('#btn-confirm');
        // Ottenimento dal localStorage solo del totale, con la sola intenzione di mostrarlo.
        const pagamento = JSON.parse(localStorage.getItem('cart_items')).total;
        console.log(pagamento);
        document.querySelector('#amountTag').innerHTML = pagamento;

        braintree.client.create({
            authorization: '{{ $token }}'
        }, function (clientErr, clientInstance) {
            if (clientErr) {
            console.error(clientErr);
            return;
            }

            // This example shows Hosted Fields, but you can also use this
            // client instance to create additional components here, such as
            // PayPal or Data Collector.

            braintree.hostedFields.create({
                client: clientInstance,
                styles: {
                    'input': {
                    'font-size': '14px'
                    },
                    'input.invalid': {
                    'color': 'red'
                    },
                    'input.valid': {
                    'color': 'green'
                    }
                },
                fields: {
                    number: {
                    container: '#card-number',
                    placeholder: '4111 1111 1111 1111'
                    },
                    cvv: {
                    container: '#cvv',
                    placeholder: '123'
                    },
                    expirationDate: {
                    container: '#expiration-date',
                    placeholder: '10/22'
                    }
                }
            }, function (hostedFieldsErr, hostedFieldsInstance) {
                if (hostedFieldsErr) {
                    console.error(hostedFieldsErr);
                    return;
                }

                submit.removeAttribute('disabled');

                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
                        if (tokenizeErr) {
                            console.error(tokenizeErr);
                            return;
                        }

                        // If this was a real integration, this is where you would
                        // send the nonce to your server.
                        console.log('Got a nonce: ' + payload.nonce);                
                        // Add the nonce to the form and submit
                        document.querySelector('#nonce').value = payload.nonce;
                        document.querySelector('#amount').value = pagamento;                
                        document.querySelector('#infoCart').value = localStorage.getItem('cart_items');
                        form.submit();
                    });
                }, false);
            });

        });
    </script>
@endsection