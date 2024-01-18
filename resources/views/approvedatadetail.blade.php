<div class="container">
    <div class="row">
        <div>Name : {{$header->user->name}}</div>
        <div>Period : {{\Carbon\Carbon::parse($header->period)->format('F Y')}}</div>
        <div>Form : {{$detail->form}}</div>
        <div>Score : {{$detail->score}} / 100</div>
    </div>
    <hr />
    <div class="row">
        @foreach ($detail->indicators as $indicator)
        <div class="row">
            <div class="col-8">
                {{$indicator->name}} ({{$indicator->weight}}%)
            </div>
            <div class="col-2">
                {{$indicator->value}}
            </div>
            <div class="col-2">
                {{$indicator->target}}
            </div>
        </div>
        @endforeach
    </div>
</div>
