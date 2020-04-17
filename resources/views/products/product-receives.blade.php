@extends('layouts.app')

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            Product Receives
            <span class="offset-md-6">
                <a href="{{route('create-product-receives')}}" type="button" class="btn btn-primary">New Receive</a>
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
                        <th scope="col">Chalan no</th>
                        <th scope="col">Product</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recivedata as $rd)
                    <tr>
                        <th scope="row">{{$rd->date}}</th>
                        <td>{{$rd->chalan}}</td>
                        <td>{{$rd->product_name}}</td>
                        <td>{{$rd->quantity}} {{$rd->unit}}</td>
                        <td>{{$rd->rate}} Tk</td>
                        <td>{{$rd->supname}}</td>
                        <td>{{$rd->remarks}}</td>
                        <td>                            
                            <form action="{{ route('product-receives-delete') }}"  method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <input type="hidden" value="{{$rd->id}}" name="id">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection