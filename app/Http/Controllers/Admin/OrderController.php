<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders')
        ->join('dish_order', 'dish_order.order_id', '=', 'orders.id' )
        ->join('dishes', 'dishes.id', '=', 'dish_order.dish_id')
        ->join('users', 'users.id', '=', 'dishes.user_id')
        ->select('orders.*')
        ->where('dishes.user_id', '=', Auth::user()->id)
        ->orderBy('orders.created_at', 'desc')
        ->groupBy('orders.id')
        ->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $orders = DB::table('orders')
        ->join('dish_order', 'dish_order.order_id', '=', 'orders.id' )
        ->join('dishes', 'dishes.id', '=', 'dish_order.dish_id')
        ->join('users', 'users.id', '=', 'dishes.user_id')
        ->select('orders.*', 'dishes.user_id')
        ->where('dishes.user_id', '=', Auth::user()->id)
        // ->orderBy('orders.created_at', 'desc')
        ->get();

        
        
        for($i = 0; $i < count($orders); ++$i) {
            
            if($orders[$i]->id == $order->id){
                return view('admin.orders.show', compact('order')); 
            }else{
                return abort(404);
            }

            
        }
        
        // return view('admin.orders.show', compact('order', 'orders'));
        
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
