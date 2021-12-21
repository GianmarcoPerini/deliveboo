@extends('layouts.app')

@section('content')
    <div class="index-wrapper container p-5 mt-4">
        
        <div class="container container-dishes-index"> 

            @if (session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                    
                </div>
            @endif
            
            <a class="btn white-butt-hover yell col-lg-2 col-12 col-md-3 mb-4" href='{{ route('admin.dashboard')}}'> Torna indietro</a>
            
            <h2 class="mb-5">Lista Piatti</h2>
            
            <a class="prim-butt col-12 col-lg-4" href="{{ route('admin.dishes.create') }}">crea un nuovo piatto</a>
            
            <table class="table mt-5">
                
                <thead>
                <tr>
                    <th scope="col-4">Nome del piatto</th>
                    <th scope="col-4">Disponibilità</th>
                    <th scope="col-2">Modifica</th>
                    <th scope="col-2">Elimina</th>
                </tr>
                </thead>
                
                <tbody>
                    @forelse ($dishes as $dish)
                        <tr >
                            <th class="align-bottom" scope="row"><a href="{{ route('admin.dishes.show', $dish->id)}}"><h3>{{ $dish->name }}</h3></a></th>
                            <th class="align-bottom" scope="row"><h3> @if($dish->available == 1 ) disponibile @else non disponibile @endif</h3></th>
                            <td class="align-middle"><a class="sec-butt" href="{{ route('admin.dishes.edit', $dish->id) }}">Edit</a></td>
                            <td>
                                
                                <form action="{{ route('admin.dishes.destroy', $dish->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="prim-butt">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Non ci sono piatti disponibili</td>
                        </tr>
                    @endforelse ($dishes as $dish)


                </tbody>
            </table>
        
        </div>

    </div>
    
    
@endsection