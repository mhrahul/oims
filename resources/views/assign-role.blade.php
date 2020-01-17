@extends('layouts.app')

@section('js')
@endsection

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">Assign Roles</div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('assign-role-process') }}">
                @csrf
                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Roles</label>
                    <div class="col-sm-10">
                        <select class="custom-select form-control form-control-sm" id="roles" name="role">
                            <option value="" selected>Choose...</option>
                            @foreach($roledata as $rd)
                            <option value="{{$rd->name}}">{{$rd->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" value="{{$uid}}" name="uid">

                <div class="form-group row">
                    <div class="col-md-12 offset-md-10">
                        <button type="submit" class="btn btn-primary"> Submit </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>


@endsection