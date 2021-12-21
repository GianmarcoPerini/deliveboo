@extends('layouts.app')


@section('content')
        <app-component dato="informazione" ></app-component>
@endsection

@section('script')    
    <script src="{{ asset('js/front.js')}}"></script>
@endsection