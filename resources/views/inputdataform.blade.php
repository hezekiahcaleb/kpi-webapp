@isset($form)

<h4 class="sub-title">{{$form->form_name}}</h4>
<table class="table">
    <tr>
        <th scope="col">Indicator</th>
        <th scope="col">Description</th>
        <th scope="col">Weight</th>
        <th scope="col">Target</th>
        <th scope="col">Actual</th>
    </tr>
    @forelse ($form->formDetails as $formDetail)
        <tr>
            <input type="text" name="result[{{$loop->index}}][indicator]" value="{{$formDetail->id}}" hidden>
            <td>{{$formDetail->indicator_name}}</td>
            <td>{{$formDetail->description}}</td>
            <td>{{$formDetail->weight}}%</td>
            <td>{{$formDetail->target}}</td>
            <td><input type="number" name="result[{{$loop->index}}][value]" placeholder="Enter Value" class="form-control" required></td>
        </tr>
    @empty
        <div>No indicators have been set.</div>
    @endforelse
</table>

@endisset
