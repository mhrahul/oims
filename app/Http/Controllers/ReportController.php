<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Validator;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function companyReceivesReport()
    {

        $supplierdata = User::role('supplier')->get();
        $productdata = Product::where('status', '=', 1)->get();

        $data = array(
            'supplierdata' => $supplierdata,
            'proddata' => $productdata,
            'totalqn' => '',
            'totalrate' => ''
        );

        return view('receive-reports')->with($data);
    }

    public function companyReceivesReportProcess(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'daterange' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $supplierdata = User::role('supplier')->get();
        $productdata = Product::where('status', '=', 1)->get();

        $date = explode(" - ", $request->input('daterange'));
        $fromDate = Carbon::parse($date[0])->format('Y-m-d');
        $toDate = Carbon::parse($date[1])->format('Y-m-d');

        $product = $request->input('products');
        $supplier = $request->input('suppliers');
        $chalan = $request->input('chalan_no');

        if (!is_null($product) && !is_null($supplier)) {
            $query = DB::table('company_receives')
                ->select(
                    'company_receives.id as id',
                    'company_receives.chalan_no as chalan_no',
                    'company_receives.quantity as quantity',
                    'company_receives.rate as rate',
                    'company_receives.receiving_date as date',
                    'company_receives.remarks as remarks',
                    'products.pname as pname',
                    'products.unit as unit',
                    'users.name as name'
                )
                ->leftJoin('products', 'company_receives.product_id', '=', 'products.id')
                ->leftJoin('users', 'company_receives.supplier_id', '=', 'users.id')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.product_id', '=', $product)
                ->where('company_receives.supplier_id', '=', $supplier)
                ->orderBy('company_receives.receiving_date', 'asc')
                ->get();

            $query2 = DB::table('company_receives')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.product_id', '=', $product)
                ->where('company_receives.supplier_id', '=', $supplier)
                ->sum('quantity');

            $query3 = DB::table('company_receives')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.product_id', '=', $product)
                ->where('company_receives.supplier_id', '=', $supplier)
                ->sum('quantity * rate');
        } elseif (isset($product) && !isset($supplier)) {
            $query = DB::table('company_receives')
                ->select(
                    'company_receives.id as id',
                    'company_receives.chalan_no as chalan_no',
                    'company_receives.quantity as quantity',
                    'company_receives.rate as rate',
                    'company_receives.receiving_date as date',
                    'company_receives.remarks as remarks',
                    'products.pname as pname',
                    'products.unit as unit',
                    'users.name as name'
                )
                ->leftJoin('products', 'company_receives.product_id', '=', 'products.id')
                ->leftJoin('users', 'company_receives.supplier_id', '=', 'users.id')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.product_id', '=', $product)
                ->orderBy('company_receives.receiving_date', 'asc')
                ->get();

            $query2 = DB::table('company_receives')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.product_id', '=', $product)
                ->sum('quantity');

            $query3 = DB::table('company_receives')
                ->select(DB::raw('sum(company_receives.quantity*company_receives.rate) AS total_sales_value'))
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.product_id', '=', $product)
                ->first();
        } elseif (!isset($product) && isset($supplier)) {
            $query = DB::table('company_receives')
                ->select(
                    'company_receives.id as id',
                    'company_receives.chalan_no as chalan_no',
                    'company_receives.quantity as quantity',
                    'company_receives.rate as rate',
                    'company_receives.receiving_date as date',
                    'company_receives.remarks as remarks',
                    'products.pname as pname',
                    'products.unit as unit',
                    'users.name as name'
                )
                ->leftJoin('products', 'company_receives.product_id', '=', 'products.id')
                ->leftJoin('users', 'company_receives.supplier_id', '=', 'users.id')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.supplier_id', '=', $supplier)
                ->orderBy('company_receives.receiving_date', 'asc')
                ->get();

            $query2 = DB::table('company_receives')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.supplier_id', '=', $supplier)
                ->sum('quantity');

            $query3 = DB::table('company_receives')
                ->select(DB::raw('sum(company_receives.quantity*company_receives.rate) AS total_sales_value'))
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->where('company_receives.supplier_id', '=', $supplier)
                ->first();
        } elseif (isset($chalan)) {
            $query = DB::table('company_receives')
                ->select(
                    'company_receives.id as id',
                    'company_receives.chalan_no as chalan_no',
                    'company_receives.quantity as quantity',
                    'company_receives.rate as rate',
                    'company_receives.receiving_date as date',
                    'company_receives.remarks as remarks',
                    'products.pname as pname',
                    'products.unit as unit',
                    'users.name as name'
                )
                ->leftJoin('products', 'company_receives.product_id', '=', 'products.id')
                ->leftJoin('users', 'company_receives.supplier_id', '=', 'users.id')
                ->where('company_receives.chalan_no', '=', $chalan)
                ->orderBy('company_receives.receiving_date', 'asc')
                ->get();

            $query2 = DB::table('company_receives')
                ->where('company_receives.chalan_no', '=', $chalan)
                ->sum('quantity');

            $query3 = DB::table('company_receives')
                ->select(DB::raw('sum(company_receives.quantity*company_receives.rate) AS total_sales_value'))
                ->where('company_receives.chalan_no', '=', $chalan)
                ->first();
        } else {
            $query = DB::table('company_receives')
                ->select(
                    'company_receives.id as id',
                    'company_receives.chalan_no as chalan_no',
                    'company_receives.quantity as quantity',
                    'company_receives.rate as rate',
                    'company_receives.receiving_date as date',
                    'company_receives.remarks as remarks',
                    'products.pname as pname',
                    'products.unit as unit',
                    'users.name as name'
                )
                ->leftJoin('products', 'company_receives.product_id', '=', 'products.id')
                ->leftJoin('users', 'company_receives.supplier_id', '=', 'users.id')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->orderBy('company_receives.receiving_date', 'asc')
                ->get();

            $query2 = DB::table('company_receives')
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->sum('quantity');

            $query3 = DB::table('company_receives')
                ->select(DB::raw('sum(company_receives.quantity*company_receives.rate) AS total_sales_value'))
                ->whereBetween('company_receives.receiving_date', array($fromDate, $toDate))
                ->first();
        }

        $data = array(
            'supplierdata' => $supplierdata,
            'proddata' => $productdata,
            'reportdata' => $query,
            'totalqn' => $query2,
            'totalrate' => $query3->total_sales_value
        );       

        return view('receive-reports')->with($data, 'data');
    }
}
