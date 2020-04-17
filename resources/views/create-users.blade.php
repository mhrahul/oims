@extends('layouts.app')

@section('js')
<script>
    jQuery(document).ready(function() {
        $("#role").change(function() {
            if ($(this).val() == 'supplier') {

                $(".passwordbl").css('display', 'none');

            } else {
                $(".passwordbl").css('display', 'block');
            }
        });
    });
</script>
@endsection

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">Create Users</div>

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
            <form method="POST" action="{{ route('create-user-process') }}">
                @csrf
                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">User</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" name="username">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Role</label>
                    <div class="col-sm-10">
                        <select class="custom-select form-control form-control-sm" id="role" name="role">
                            <option value="" selected>Choose...</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row passwordbl" style="display: none;">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control form-control-sm" name="password" placeholder="Min 6 charecters">
                    </div>
                </div>

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