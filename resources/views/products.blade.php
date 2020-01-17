@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            Products
            <span class="offset-md-9">
                <a href="{{route('create-product')}}" type="button" class="btn btn-primary">Add Product</a>
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
                        <th scope="col">Unit</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proddata as $pd)
                    <tr>
                        <th scope="row">{{$pd->id}}</th>
                        <td>{{$pd->sku}}</td>
                        <td>{{$pd->pname}}</td>
                        <td>{{$pd->unit}}</td>
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