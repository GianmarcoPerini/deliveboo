@extends('layouts.app')

@section('content')


    <div class="show-wrapper container p-4">

        <div class="container container-show">

            @if (session('message'))
            <div class="alert alert-success">
                {{session('message')}}
                
            </div>
            @endif
    
            <h1 class="mb-3">{{$dish->name}}</h1>
            <div class="mb-3 image-container text-center p-3">
                <div class="image-wrapper container">
                    <img src="{{ $dish->getImagePrefix() . $dish->image}}" alt="">
                </div>
            </div>
            <!-- Contenitore dei bottoni -->
            <div class="container-button row justify-content-center">
                <div class="single-btn-box col-lg-3 col-12 align-self-center">
                    <a href=" {{ route('admin.dishes.index')}}" class="sec-butt">Torna alla lista dei piatti</a>
                </div>
                <div class="single-btn-box col-lg-2 col-12">
                    <form action="{{ route('admin.dishes.destroy', $dish->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="prim-butt">Elimina il piatto</button>
                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection