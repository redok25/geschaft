<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    use ValidatorTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Sale::with('customer', 'detail', 'detail.product');

            return DataTables::eloquent($model)
                ->editColumn('id', function ($d) {
                    return Crypt::encrypt($d->id);
                })
                ->make(true);
        }

        $data['customer'] = Customer::all();
        $data['product'] = Product::all();

        return view('pages.order', $data);
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => 'required',
            'order.*.product' => 'required',
        ], [
            'customer.required' => 'The customer field is required.',
            'order.*.product.required' => 'The product field is required for each order.',
        ]);



        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }

        // dd($request->all());

        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'customer_id' => $request->customer
            ]);

            $total = 0;
            foreach ($request->order as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product'],
                    'qty' => $item['qty'],
                    'total' => $item['total'],
                ]);
                $total += $item['total'];
            }

            $sale->update(['total' => $total]);

            toast('Successfuly order product!', 'success');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            toast('There was an error while processing the request!', 'error');
        }

        return redirect()->route('sale');
    }
}
