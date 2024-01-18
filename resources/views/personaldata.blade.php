@php
    $user = auth()->user();
@endphp

<form action="/update-personaldata" method="POST" class="container mt-4">
    @csrf
    {{-- <div class="row">
        <h5>Avatar</h5>
    </div> --}}
    <div class="row form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter name" value="{{$user->name}}">
    </div>
    <div class="row form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{$user->email}}">
    </div>
    <div class="text-end">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
