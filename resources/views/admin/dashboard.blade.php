@extends('layouts.app')

@section('content')
<div class="container dashboard-wrapper p-5">

    <div class="container container-dashboard">
        <!-- Contenitore generale contenuti -->
        <!-- <div class="justify-content-center"> -->
            
        <div class="row justify-content-center">

            <div class="login-container col-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        
            <div class="container-status col-12">
                <p class="status-info white-butt mb-4 col-5 col-lg-2">{{ __('Login effettuato!') }}</p>
            </div>

        <!-- contenitore username e bottoni di reindirizzamento -->
            <div class="container container-btn-name justify-content-between mb-4 row">

                <div class="col-12 col-lg-7">
                    <h2 class="">Bentornato: {{ $user->name }}</h2>
                </div>

                <div class="container-button align-self-center col-12 col-lg-4">
                        <a class="prim-butt" href="{{ route('admin.dishes.index')}}">I tuoi Piatti</a>
                        <a class="sec-butt" href="{{ route('admin.orders.index')}}">Ordini ricevuti</a>
                </div>
                    
            </div>

            <div class="container-img mt-2 text-center">
                <img class="img-fluid" src="{{ $user->getImagePrefix() . $user->image}}" alt="{{$user->name}} copertina immagine">
            </div>

        </div>
        <!-- if per mostrare la descrizione del prodotto quando è presente -->
        @if ($user != null)
        <div class="container-description mt-5">
            <p> {{ $user->description }} </p>
        </div>
        @else
        <div class="container-description mt-5">

        </div>
        @endif

    </div>
</div>
@endsection
