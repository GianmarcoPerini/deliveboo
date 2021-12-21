@extends('layouts.app')

@section('content')
<div class="container index-wrapper p-5">

    <div class="container container-order-index">

        <div class="row">

            <a class="btn white-butt-hover yell mb-5" href='{{ route('admin.dashboard')}}'> Torna indietro</a>

            <table class="table">
            
                <thead>
                <tr>
                    <th scope="col">N. Ordine</th>
                    <th scope="col">Nome & Cognome</th>
                    {{-- <th scope="col">Telefono</th>
                    <th scope="col">Indirizzo</th> --}}
                    <th scope="col">Data Ordine</th>
                </tr>
                </thead>
                
                <tbody>
                    
                    @forelse ($orders as $order)
                        <tr>
                            <th scope="row">{{$order->id}}</th>
                            <td><a href="{{ route('admin.orders.show', $order->id)}}">{{$order->name . ' ' .$order->surname}}</a> </td>                            
                            {{-- <td>{{$order->phone}}</td>
                            <td>{{$order->city . ', ' . $order->address . ', ' . $order->zip_code}}</td> --}}
                            <td>{{$order->created_at}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Non ci sono ordini disponibili</td>
                        </tr>
                    @endforelse
    
                </tbody>
            </table>

        </div>

    </div>

</div>
@endsection