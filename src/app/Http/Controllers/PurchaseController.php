<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use Inertia\Inertia;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::groupBy('id')
            ->selectRaw('id, customer_name, 
            sum(subtotal) as total, status, created_at')->paginate(50);

        return Inertia::render('Purchases/Index', [
            'orders' => $orders
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::select('id', 'name', 'price')
            ->where('is_selling', true)
            ->get();

        return Inertia::render('Purchases/Create', [
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {

        DB::beginTransaction();
        
        try {
            $purchase = Purchase::create([
                'customer_id' => $request->customer_id,
                'status' => $request->status
            ]);
    
            foreach($request->items as $item){
                $purchase->items()->attach($purchase->id, [
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity']
                ]);
            }
            
            DB::commit();
            return to_route('dashboard');
        } catch(\Exception $e) {
            DB::rollback();
        } 

    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $items = Order::where('id', $purchase->id)->get();

        // 合計
        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_name, 
            sum(subtotal) as total, status, created_at')->get();

        return Inertia::render('Purchases/Show', [
            'items' => $items,
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $purchase = Purchase::find($purchase->id);
        $allItems = Item::select('id', 'name', 'price')->get();

        $items = [];

        foreach($allItems as $allItem) {
            $quantity = 0;
            foreach($purchase->items as $item) {
                if ($allItem->id === $item->id) {
                    $quantity = $item->pivot->quantity;
                }
            }
            array_push($items, [
                'id' => $allItem->id,
                'name' => $allItem->name,
                'price' => $allItem->price,
                'quantity' => $quantity,
            ]);
        }

        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_id, customer_name, status, created_at')->get();

        // dd($items);
        return Inertia::render('Purchases/Edit', [
            'items' => $items,
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        DB::beginTransaction();
        
        try {

            $purchase->status = $request->status;
            $purchase->save();
    
            $items = [];
            
            foreach($request->items as $item) {
                $items = $items + [
                    $item['id'] => [
                        'quantity' => $item['quantity']
                    ],
                ];
            }
            // dd($items);
            $purchase->items()->sync($items);

            DB::commit();
            return to_route('dashboard');
        } catch(\Exception $e) {
            DB::rollback();
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
