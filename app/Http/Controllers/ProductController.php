<?php

namespace App\Http\Controllers;

use App\Models\CompanyStock;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\SupplierRequisition;
use App\Models\CompanyReceive;
use Validator;
use DB;
use Carbon\Carbon;
use Auth;

class ProductController extends Controller
{
    public function index()
    {
        $proddata = Product::get();
        return view('products.products')->with('proddata', $proddata);
    }

    public function createProducts()
    {
        return view('products.create-product');
    }
    public function createProductsProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku' => 'required',
            'proname' => 'required',
            'unit' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = new Product;
        $product->sku = $request->input('sku');
        $product->pname = $request->input('proname');
        $product->unit = $request->input('unit');
        $product->status = 1;
        $product->save();

        return redirect('products');
    }

    public function editProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prodid' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $prodid = $request->input('prodid');
        $data = Product::findOrFail($prodid);

        return view('products.edit-product')->with('productdata', $data);
    }

    public function editProductsProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'required',
            'sku' => 'required',
            'proname' => 'required',
            'unit' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($request->input('pid'));
        $product->sku = $request->input('sku');
        $product->pname = $request->input('proname');
        $product->unit = $request->input('unit');
        $product->status = 1;
        $product->save();

        return redirect('products');
    }

    public function deleteProductsProcess(Request $request)
    {
        $id = $request->input('id');
        $getResult = CompanyReceive::where('product_id', '=', $id)->get();

        if ($getResult->isEmpty()) {
            $del = Product::find($id);
            $del->delete();
            return redirect('products');
        } else {
            return back()->withErrors(['Product already have dependency']);
        }
    }

    public function companyProductDetails()
    {
        $proddata = DB::table('company_stocks')
            ->select('users.name as supplier_name', 'products.id as id', 'products.sku as sku', 'products.pname as product_name', 'products.unit as unit', 'company_stocks.quantity as quantity', 'company_stocks.purch_price_pr_unit as unit_price')
            ->leftJoin('products', 'company_stocks.pid', '=', 'products.id')
            ->leftJoin('users', 'company_stocks.sup_id', '=', 'users.id')
            ->get();
        return view('company-stock')->with('proddata', $proddata);
    }

    /**
     * Product Requisitons
     */
    public function productRecusitionCompany()
    {
        $data = DB::table('supplier_requisitions')
            ->select('supplier_requisitions.id as id', 'products.sku as sku', 'products.pname as product_name', 'products.unit as unit', 'supplier_requisitions.quantity as quantity', 'users.name as supname', 'supplier_requisitions.status as status', 'supplier_requisitions.date as date', 'supplier_requisitions.requiser_id as requiser')
            ->leftJoin('products', 'supplier_requisitions.product_id', '=', 'products.id')
            ->leftJoin('users', 'supplier_requisitions.supplier_id', '=', 'users.id')
            ->where('supplier_requisitions.status', '=', 'open')
            ->get();
        return view('products.product-requisition-company')->with('proddata', $data);
    }
    public function createProductRecusition(Request $request)
    {
        $supplierdata = User::role('supplier')->get();
        $productdata = Product::where('status', '=', 1)->get();

        $data = array('supplierdata' => $supplierdata, 'proddata' => $productdata);

        return view('products.create-product-requisition')->with($data);
    }

    public function productRecusitionProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier' => 'required',
            'products' => 'required|array',
            'quantity' => 'required|array'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $uid = Auth::user()->id;
        $date = Carbon::today()->toDateString();
        $supplier = $request->input('supplier');
        $proddata = $request->input('products');
        $pqn = $request->input('quantity');
        for ($i = 0; $i < count($proddata); $i++) {
            $supreq = new SupplierRequisition;
            $supreq->product_id = $proddata[$i];
            $supreq->quantity = $pqn[$i];
            $supreq->supplier_id = $supplier;
            $supreq->requiser_id = $uid;
            $supreq->date = $date;
            $supreq->status = 'open';
            $supreq->save();
        }

        return redirect('product-requisition-company');
    }

    public function deleteProductRecusition(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $preq = SupplierRequisition::findOrFail($request->input('id'));
        $preq->delete();
        return redirect('product-requisition-company');
    }

    public function productRecusitionSupplier()
    {
        $uid = Auth::user()->id;
        $data = DB::table('supplier_requisitions')
            ->select('supplier_requisitions.id as id', 'products.sku as sku', 'products.pname as product_name', 'products.unit as unit', 'supplier_requisitions.quantity as quantity', 'users.name as reqname', 'supplier_requisitions.status as status', 'supplier_requisitions.date as date')
            ->leftJoin('products', 'supplier_requisitions.product_id', '=', 'products.id')
            ->leftJoin('users', 'supplier_requisitions.requiser_id', '=', 'users.id')
            ->where('supplier_requisitions.supplier_id', '=', $uid)
            ->get();
        return view('products.product-requisition-supplier')->with('proddata', $data);
    }

    public function productRecusitionCompleteProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_req' => 'required'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $sr = $request->input('supplier_req');
        $date = Carbon::today()->toDateString();

        $srdata = SupplierRequisition::find($sr);

        $csdata = new CompanyStock;
        $csdata->pid = $srdata->product_id;
        $csdata->quantity = $srdata->quantity;
        $csdata->purch_price_pr_unit = 0.00;
        $csdata->sup_id = Auth::user()->id;
        $csdata->date = $date;
        $csdata->save();

        $srdata->status = 'closed';
        $srdata->save();

        return redirect('products.product-requisition-supplier');
    }

    public function companyReceives()
    {
        $receiveData = DB::table('company_receives')
            ->select(
                'company_receives.id as id',
                'company_receives.chalan_no as chalan',
                'company_receives.quantity as quantity',
                'company_receives.rate as rate',
                'company_receives.receiving_date as date',
                'company_receives.remarks as remarks',
                'products.pname as product_name',
                'products.unit as unit',
                'users.name as supname'
            )
            ->leftJoin('products', 'company_receives.product_id', '=', 'products.id')
            ->leftJoin('users', 'company_receives.supplier_id', '=', 'users.id')
            ->get();

        $data = array('recivedata' => $receiveData);

        return view('products.product-receives')->with($data);
    }

    public function createCompanyReceives()
    {
        $supplierdata = User::role('supplier')->get();
        $productdata = Product::where('status', '=', 1)->get();

        $data = array(
            'supplierdata' => $supplierdata,
            'proddata' => $productdata
        );

        return view('products.create-product-receives')->with($data);
    }
    public function companyReceivesProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receive_date' => 'required',
            'supplier' => 'required',
            'products' => 'required|array',
            'quantity' => 'required|array'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $rd = $request->input('receive_date');
        $date = Carbon::parse($rd)->format('Y-m-d');

        $supplier = $request->input('supplier');
        $chalan = $request->input('chalan');
        $proddata = $request->input('products');
        $pqn = $request->input('quantity');
        $rate = $request->input('rate');
        $remarks = $request->input('remarks');

        for ($i = 0; $i < count($proddata); $i++) {
            $comreq = new CompanyReceive;
            $comreq->chalan_no = $chalan[$i];
            $comreq->supplier_id = $supplier;
            $comreq->product_id = $proddata[$i];
            $comreq->quantity = $pqn[$i];
            $comreq->rate = $rate[$i];
            $comreq->status = 0;
            $comreq->receiving_date = $date;
            $comreq->remarks = $remarks[$i];
            $comreq->save();
        }

        return redirect('product-receives');
    }

    public function companyReceivesDelete(Request $request)
    {
        $id = $request->input('id');
        $del = CompanyReceive::where('id', '=', $id)->delete();
        return redirect('product-receives');
    }

}
