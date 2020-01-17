@extends('layouts.app')

@section('js')
@endsection

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">Dashboard</div>

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
                        <th scope="col">Full Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $ud)
                    <tr>
                        <th scope="row">{{$ud->id}}</th>
                        <td>{{$ud->name}}</td>
                        <td>{{$ud->email}}</td>
                        <td>
                            @foreach($ud->roles as $ur)
                            <span>{{$ur->name}}</span>
                            @endforeach
                        </td>
                        <td>
                            <a type="button" class="btn btn-primary" href="{{ route('assign-role',$ud->id) }}">Add Roles</a>
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