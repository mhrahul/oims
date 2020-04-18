@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
</script>
@endsection

@section('content')

<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            Product Receives Report
        </div>

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif


            <form class="form-inline" method="post" action="{{ route('receives-report-process') }}">
                @csrf
                <div class="form-group mb-2">
                    <label for="date" class="sr-only">Date</label>
                    <input type="text" class="form-control" name="daterange" />
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="products" class="sr-only">Products</label>
                    <select class="custom-select form-control form-control-sm product_list" name="products" value="{{ old('products') }}">
                        <option value="" selected>Choose Products</option>
                        @foreach($proddata as $pd)
                        <option value="{{$pd->id}}">{{$pd->pname}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="suppliers" class="sr-only">Suppliers</label>
                    <select class="custom-select form-control form-control-sm product_list" name="suppliers" value="{{ old('suppliers') }}">
                        <option value="" selected>Choose Suppliers</option>
                        @foreach($supplierdata as $sd)
                        <option value="{{$sd->id}}">{{$sd->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mx-sm-3 mb-2">                    
                    <input class="form-control form-control-sm" type="text" name="chalan_no" placeholder="Chalan No" value="{{ old('chalan_no') }}"> 
                </div>
                <button type="submit" class="btn btn-primary btn-md mb-2">Search</button>
            </form>
            <div>
                <ul>
                    <li>
                        Total Quantity: {{ $totalqn }}
                    </li>
                    <li>
                        Total Rate: {{ $totalrate }} Tk
                    </li>
                </ul>
            </div>

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
                    @if(isset($reportdata))
                    @foreach($reportdata as $rd)
                    <tr>
                        <th scope="row">{{$rd->date}}</th>
                        <td>{{$rd->chalan_no}}</td>
                        <td>{{$rd->pname}}</td>
                        <td>{{$rd->quantity}} {{$rd->unit}}</td>
                        <td>{{$rd->rate}} Tk</td>
                        <td>{{$rd->name}}</td>
                        <td>{{$rd->remarks}}</td>
                        <td>
                            <form action="{{ route('product-receives-delete') }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                                <input type="hidden" value="{{$rd->id}}" name="id">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection