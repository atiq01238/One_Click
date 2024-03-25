
<div class="text-danger">
    @if ($errors->has('login'))
        {{ $errors->first('login') }}
    @endif
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif



