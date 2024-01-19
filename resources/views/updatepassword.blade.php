<form action="update-password" method="POST" class="container">
    @csrf
    <div class="row form-group">
        <label for="oldpassword">Old password</label>
        <input type="password" class="form-control" name="oldpassword">
    </div>
    <div class="row form-group">
        <label for="newpassword">New password</label>
        <input type="password" class="form-control" name="newpassword">
    </div>
    <div class="row form-group">
        <label for="confirmpassword">Confirm password</label>
        <input type="password" class="form-control" name="newpassword_confirmation">
    </div>
    <div class="text-end me-2">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
