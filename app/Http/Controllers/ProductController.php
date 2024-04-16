<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    use ValidatorTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Product::query();

            return DataTables::eloquent($model)
                ->editColumn('id', function ($d) {
                    return Crypt::encrypt($d->id);
                })
                ->make(true);
        }
        return view('pages.product');
    }

    public function post(Request $request)
    {
        $this->set_validator($request->all(), [
            'name' => 'required',
            'price' => 'required|integer'
        ]);

        DB::beginTransaction();

        try {

            Product::updateOrCreate(
                ['id' => !empty($request->data_id) ? Crypt::decrypt($request->data_id) : null],
                [
                    'name' => $request->name,
                    'price' => $request->price
                ]
            );

            $message = 'Successfully create product!';
            if (!empty($request->data_id)) $message = 'Successfully update product!';

            toast($message, 'success');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            toast('There was an error while processing the request!', 'error');
        }

        return redirect()->route('product');
    }
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            Product::destroy(Crypt::decrypt($id));
            DB::commit();

            toast('Successfully delete product!', 'success');
        } catch (\Throwable $th) {
            DB::rollback();
            toast('There was an error while processing the request!', 'error');
        }

        return redirect()->route('product');
    }
}
