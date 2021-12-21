<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Dish;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dishes = Dish::where('user_id',Auth::user()->id)->get();
        
        return view('admin.dishes.index',compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dishes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:200',
            'price' => 'required|min:1|max:9999',
            'weigth' => 'nullable|string|max:255',
        ],
        [
            "required" => "Inserisci un campo valido per :attribute",
            "price.required" => "Inserisci un prezzo valido",
        ]);

        $data = $request->all();

        if($request->has('available')){
            $data['available'] = 1;
            } else {
            $data['available']= 0;
            };

        
        $data['user_id'] = Auth::user()->id;
        $data['image'] = Storage::put('dishes/images', $data['image']);
        $newDish = new Dish();
        $newDish->fill($data);
        $newDish->save();

        return redirect()->route('admin.dishes.show', $newDish->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
        if(Auth::user()->id == $dish->user_id){
            return view('admin.dishes.show', compact('dish'));
        }else{
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        return view('admin.dishes.edit', compact('dish'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:200',
            'price' => 'required|min:1|max:9999',
            'weigth' => 'nullable|string|max:255',
        ],
        [
            "required" => "Inserisci un campo valido per :attribute",
            "price.required" => "Inserisci un prezzo valido",
        ]);

        $data = $request->all();

        if($request->has('available')){
            $data['available'] = 1;
            } else {
            $data['available']= 0;
            };

        
        $data['user_id'] = Auth::user()->id;
        $data['image'] = Storage::put('dishes/images', $data['image']);

        // if($data['available']) {
        //     $data['available'] = 1;
        // }else {
        //     $data['available'] = 1;
        // }
        // dd($data['available']);

        
        $dish->fill($data);
        $dish->update();

        return redirect()->route('admin.dishes.show', compact('dish'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        
        return redirect()->route('admin.dishes.index')->with('message', "Il piatto '$dish->name' è stato eliminato");
    }
}
