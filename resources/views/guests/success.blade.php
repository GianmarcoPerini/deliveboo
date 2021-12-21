@extends('layouts.app')

@section('content')

    @if (session('success_message'))
    <div class="alert alert-success">
        {{ session('success_message') }}
    </div>
    @endif

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <h2>Pagamento avvenuto con sucesso</h2>
@endsection

@section('script')
    <script>
        window.onload = function() {
            localStorage.removeItem('cart_items')
        }
    </script>
@endsection