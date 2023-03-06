@if($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong>{{$message}}</strong>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong>{{$message}}</strong>
    </div>
@endif

@if($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong>{{$message}}</strong>
    </div>
@endif


