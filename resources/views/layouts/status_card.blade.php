<div class="card">
    <div class="card-header">{{ __('main.Dashboard') }}</div>
    <div class="card-body">
        {{ __('main.You are logged in!') }} 
        @if($errors->any())
            <div class="col-xs-12">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @elseif(session('status'))
            <div class="col-xs-12">
                <div class="alert alert-success">
                    {!! session('status') !!}
                </div>
            </div>
        @endif
    </div>
</div>
