<hr />
<div class="container">
    <div class="row">
        <div>Form : {{$summary->form}}</div>
        <div>Score : {{number_format($summary->score), 2, '.', ''}} / 100</div>
    </div>
    <br>
    <div class="row">
        @foreach ($summary->indicators as $indicator)
        <div class="row">
            <div class="col-8">
                {{$indicator->name}} ({{$indicator->weight}}%)
            </div>
            <div class="col-2 text-end">
                {{$indicator->value}} / {{$indicator->target}}
            </div>
        </div>
        @endforeach
    </div>
</div>
