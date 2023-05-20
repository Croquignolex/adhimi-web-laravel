@if(session('alert.message'))
    <div class="alert alert-{{ session('alert.type') }} alert-dismissible fade show mt-50" role="alert">
        <div class="alert-body">
            <i data-feather="{{ session('alert.icon') }}" class="mr-50 align-middle"></i>
            <span>{{ session('alert.message') }}</span>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif