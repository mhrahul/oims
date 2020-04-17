@extends('layouts.app')

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var i = 1;
        $('#add').click(function() {
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="chalan[]" placeholder="Chalan No" class="form-control name_list" /></td><td><select class="custom-select form-control form-control-sm product_list" name="products[]"><option selected>Products</option>@foreach($proddata as $pd)<option value="{{$pd->id}}">{{$pd->pname}}</option>@endforeach</select></td><td><input type="text" name="quantity[]" placeholder="Quantity" class="form-control name_list" /></td><td><input type="text" name="rate[]" placeholder="Price" class="form-control name_list" /></td><td><input type="text" name="remarks[]" placeholder="Remarks" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });


        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $(".print-success-msg").css('display', 'none');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }

        $(function() {
            $('#datepicker').datepicker().datepicker("setDate", new Date());            
        });
    });
</script>
@endsection

@section('content')

<div class="col-md-8">
    <div class="card">
        <div class="card-header">Product Receive Form</div>

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
            <form method="POST" action="{{ route('product-receives-process') }}">
                @csrf
                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Date</label>
                    <div class="col-sm-10 input-group date" id='datepicker'>
                        <input type="text" class="form-control" name="receive_date" value="" placeholder="Receive Date">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Supplier</label>
                    <div class="col-sm-10">
                        <select class="custom-select form-control form-control-sm" name="supplier">
                            <option selected>Choose Supplier</option>
                            @foreach($supplierdata as $sd)
                            <option value="{{$sd->id}}">{{$sd->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dynamic_field">
                        <tr>
                            <td>
                                <input type="text" name="chalan[]" placeholder="Chalan No" class="form-control name_list" />
                            </td>
                            <td>
                                <select class="custom-select form-control form-control-sm product_list" name="products[]">
                                    <option selected>Products</option>
                                    @foreach($proddata as $pd)
                                    <option value="{{$pd->id}}">{{$pd->pname}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="quantity[]" placeholder="Quantity" class="form-control name_list" />
                            </td>
                            <td>
                                <input type="text" name="rate[]" placeholder="Price" class="form-control name_list" />
                            </td>
                            <td>
                                <input type="text" name="remarks[]" placeholder="Remarks" class="form-control name_list" />
                            </td>
                            <td><button type="button" name="add" id="add" class="btn btn-success btn-md">Add</button></td>
                        </tr>
                    </table>
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