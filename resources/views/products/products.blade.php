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

            @if($errors->any())
            <div class="alert alert-danger" role="alert">{{$errors->first()}}</div>
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
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <form action="{{ route('edit-product') }}" method="post">
                                    @csrf
                                    @method('post')
                                    <input type="hidden" value="{{$pd->id}}" name="prodid">
                                    <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                                </form>
                                <form action="{{ route('delete-product') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" value="{{$pd->id}}" name="id">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection