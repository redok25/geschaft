<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    use ValidatorTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Customer::query();

            return DataTables::eloquent($model)
                ->editColumn('id', function ($d) {
                    return Crypt::encrypt($d->id);
                })
                ->make(true);
        }
        return view('pages.customer');
    }

    public function post(Request $request)
    {
        $this->set_validator($request->all(), [
            'name' => 'required'
        ]);

        DB::beginTransaction();

        try {

            Customer::updateOrCreate(
                ['id' => !empty($request->data_id) ? Crypt::decrypt($request->data_id) : null],
                [
                    'name' => $request->name
                ]
            );

            $message = 'Successfully create customer!';
            if (!empty($request->data_id)) $message = 'Successfully update customer!';

            toast($message, 'success');
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            toast('There was an error while processing the request!', 'error');
        }

        return redirect()->route('customer');
    }
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            Customer::destroy(Crypt::decrypt($id));
            DB::commit();

            toast('Successfully delete customer!', 'success');
        } catch (\Throwable $th) {
            DB::rollback();
            toast('There was an error while processing the request!', 'error');
        }

        return redirect()->route('customer');
    }
}
