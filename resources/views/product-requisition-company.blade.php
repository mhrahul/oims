@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            Product Requisitions
            <span class="offset-md-6">
            <a href="{{route('product-requisition-form')}}" type="button" class="btn btn-primary">New Requisition</a>
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
                        <th scope="col">Date</th>
                        <th scope="col">SKU</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proddata as $pd)
                    <tr>
                        <th scope="row">{{$pd->date}}</th>
                        <td>{{$pd->sku}}</td>
                        <td>{{$pd->product_name}}</td>
                        <td>{{$pd->quantity}} {{$pd->unit}}</td>
                        <td>{{$pd->supname}}</td>
                        <td>{{$pd->status}}</td>
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