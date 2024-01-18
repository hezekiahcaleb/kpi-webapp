@extends('layout')

@section('title', 'Input KPI - KPI Monitoring App')

@section('heading', 'Input KPI Data')

@section('content')

<div class="container form-container offwhite-bg">
    <form action="/savekpi" method="POST">
        @csrf
        <div class="row ms-1">
            <div class="form-group col">
                <label for="period" class="row">Period</label>
                <input type="month" class="row" name="period" id="period">
            </div>
            <div class="form-group col">
                <label for="selectform" class="row">Form</label>
                <select name="selectform" id="selectform" class="row" disabled>
                    <option value="" selected disabled>-</option>
                    {{-- @foreach ($forms as $form)
                        <option value="{{$form->id}}">{{$form->form_name}}</option>
                    @endforeach --}}
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

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function (){
        $('#period').change(function(){
            var selectedPeriod = $(this).val();
            $.ajax({
                url: '/getFormsByDate/' + selectedPeriod,
                type: 'GET',
                success: function(data){
                    $('#selectform').empty();
                    if(data.length <= 0){
                        $('#selectform').prop("disabled", true);
                        $('#selectform').append($('<option>').val(null).text("Form unavailable"));
                        $('#selectform').val(null).trigger('change');
                    } else {
                        $('#selectform').prop("disabled", false);
                        $.each(data, function(key, value){
                            $('#selectform').append($('<option>').val(key).text(value));
                            $('#selectform').val(key).trigger('change');
                        });
                    }
                }
            }).fail(function(){
                $('#selectform').prop("disabled", true);
                $('#selectform').empty();
                $('#selectform').append($('<option>').val(null).text("Form unavailable"));
            });
        })

        $('#selectform').change(function(){
            var selectedForm = $(this).val();
            if(!selectedForm == "" && !selectedForm == null){
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
            }
        });
    });
</script>
@endsection
