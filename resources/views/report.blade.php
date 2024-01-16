<hr />
<div class="container">
    <div class="row">
        <p>Form : {{$summary->form}}</p>
        <p>Score : {{$summary->score}}/100</p>
    </div>
    <div class="row">
        @foreach ($summary->indicators as $indicator)
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
