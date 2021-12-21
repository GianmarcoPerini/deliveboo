@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <div class="row">
        <a href="{{ route('admin.orders.index')}}" class="text-center col-lg-3 col-12 sec-butt">Torna alla lista degli ordini</a>
    </div>
</div>

<div class="container show-wrapper">
    
    <div class="container">
        <div class="row p-4">
            <h2 class="col-12 pb-3">Dettaglio Ordine</h2>
            
                <h4 class="col-12 card-title"> Nome e Cognome: {{$order->name . ' ' .$order->surname}} </h4>
                <address class="col-12"> Indirizzo: {{$order->city . ', ' . $order->address . ', ' . $order->zip_code}} </address>
                <address class="col-12"> Numero di telefono: {{ $order->phone}} </address>
                {{-- <span class="col-12">{{ $order->dishes['user_id']}} </span> --}}
                
            
        </div>
    </div>
</div>

@endsection