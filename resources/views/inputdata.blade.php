@extends('layout')

@section('title', 'Input KPI - KPI Monitoring App')

@section('heading', 'Input KPI Data')

@section('content')

<div class="container form-container offwhite-bg">
    <form action="/savekpi" method="POST">
        @csrfhtm
        <div class="row ms-1">
            <div class="form-group col">
                <label for="period" class="row">Period</label>
                <input type="month" class="row" name="period" id="period">
            </div>
            <div class="form-group col">
                <label for="selectform" class="row">Form</label>
                <select name="selectform" id="selectform" class="row">
                    <option value="" selected disabled>-</option>
                    @foreach ($forms as $form)
                        <option value="{{$form->id}}">{{$form->form_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr class="row my-4" />
        @isset($forms)
            <div class="row">
                <div class="form-group col" id="dynamic-form">
                </div>
            </div>
            <div class="row justify-content-end" id="save-btn" hidden>
                <button type="submit" class="btn btn-primary col-1">Submit</button>
            </div>
        @else
            <div class="col">No forms has been assigned!</div>
        @endisset
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#selectform').change(function(){
            var selectedForm = $(this).val();
            $.ajax({
                url: '/getform/' + selectedForm,
                type: 'GET',
                success: function(response){
                    $('#dynamic-form').html(response);
                    $('#save-btn').removeAttr('hidden');
                }
            })
            .fail(function(){
                $('#dynamic-form').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            });
        });
    });
</script>

@endsection
