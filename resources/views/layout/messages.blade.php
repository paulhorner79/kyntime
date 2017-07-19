@if (Session::has('error'))
<div class="alerts">
    <div class="alert alert-danger">
        {{Session::get('error')}}
    </div>
</div>
@endif
@if (Session::has('success'))
<div class="alerts">
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
</div>
@endif
@if (Session::has('warning'))
<div class="alerts">
    <div class="alert alert-warning">
        {{Session::get('warning')}}
    </div>
</div>
@endif

@if (isset($errors) and count($errors))
<div class="alerts">
    <div class="alert alert-danger">
        The following errors were found in the form you submitted:
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
