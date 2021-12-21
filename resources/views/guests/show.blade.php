@extends('layouts.app')

@section('content')
    <div class="container mb-3">
        <div class="row">
            <h2 class="col-12 text-white">Ristorante: {{$user->name}}</h2>
        </div>
    </div>
    <show-component :dato="{{ $dishes }}"></show-component>
@endsection

@section('script')
    <script src="{{ asset('js/front.js')}}"></script>
@endsection