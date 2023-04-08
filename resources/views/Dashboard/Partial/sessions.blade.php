@if (Session::has('success'))
<br>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
         {{ session('success') }}
    </div>
@endif


@if (Session::has('danger'))
<br>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
         {{ session('danger') }}
    </div>
@endif


@if (Session::has('warning'))
<br>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
         {{ session('warning') }}
    </div>
@endif
