<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rows = Product::
        withsum('sub_invoice', 'price')
            ->withsum('inventories', 'sum_price')
            ->with('inventories')
            ->when($request->get('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->get('remaining_from'), function ($query) use ($request) {
                $query->where('remaining', '>=', $request->input('remaining_from'));
            })
            ->when($request->get('remaining_to'), function ($query) use ($request) {
                $query->where('remaining', '<=', $request->input('remaining_to'));
            })
            ->paginate(30);
        return view('panel.product.index', ['rows' => $rows]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $row = Product::create([
            'author' => auth()->user()->id,
            'name' => $request->name,
            'price' => $request->price,
        ]);
        alert()->success('محصول جدید با موفقیت افزوده شد', 'عملیات موفق');

        return redirect('products');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $row = Product::where('id', $id)->first();
        $row->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);
        alert()->success('محصول با موفقیت ویرایش شد', 'عملیات موفق');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = Product::where('id', $id)->first();
        $row->delete();
    }

    public function inventory(Request $request)
    {
        $inventory = Inventory::create([
            'author' => auth()->user()->id,
            'product_id' => $request->product_id,
            'date' => $request->input('date-picker-shamsi-list'),
            'count' => $request->count,
            'purchase_price' => $request->price,
            'sum_price' => $request->price * $request->count,
        ]);
        $product = Product::where('id', $request->product_id)->first();
        $product->update([
            'remaining' => $product->remaining + $request->count
        ]);

        alert()->success('محصول با موفقیت اضافه شد', 'عملیات موفق');

        return back();
    }
}
