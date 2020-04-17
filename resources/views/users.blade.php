@extends('layouts.app')

@section('js')
@endsection

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">
            Dashboard
            <span class="offset-md-9">
                <a href="{{route('create-users')}}" type="button" class="btn btn-secondary">Add User</a>
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
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a type="button" class="btn btn-primary btn-sm" href="{{ route('assign-role',$ud->id) }}">Add Roles</a>
                                <form action="{{ route('delete-user') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" value="{{$ud->id}}" name="id">
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