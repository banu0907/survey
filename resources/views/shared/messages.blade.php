@foreach(['danger','warning','success','info'] as $msg)
    @if(session()->has($msg))
        <div class="flash-message container">
            <p class="alert alert-{{ $msg }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session()->get($msg) }}
            </p>
        </div>
    @endif
@endforeach