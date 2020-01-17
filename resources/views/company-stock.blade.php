@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            Company Stock
            <span class="offset-md-7">
                <a href="{{route('product-requisition-form')}}" type="button" class="btn btn-primary">Product Requisition</a>
            </span>
        </div>

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price (Unit)</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proddata as $pd)
                    <tr>
                        <th scope="row">{{$pd->id}}</th>
                        <td>{{$pd->sku}}</td>
                        <td>{{$pd->product_name}}</td>
                        <td>
                            @if(isset($pd->quantity))
                                {{$pd->quantity}} {{$pd->unit}}
                            @else
                                0 {{$pd->unit}}
                            @endif

                        </td>
                        <td>{{$pd->unit_price}}</td>
                        <td>{{$pd->supplier_name}}</td>
                        <td>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection