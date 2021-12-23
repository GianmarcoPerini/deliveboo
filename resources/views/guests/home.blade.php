@extends('layouts.app')


@section('content')
        <app-component></app-component>
@endsection

@section('script')    
    <script src="{{ asset('js/front.js')}}"></script>
@endsection