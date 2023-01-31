<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@includeif('layouts.top_menu')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
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
                    @else {{ __('main.ResetPassword') }}
                    @endif  
                </div>
                <div class="card-body">
                        @if(Route::currentRouteName()  == "password.reset_link")
                        
                        <form method="POST" action="{{ route('password.send_link') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ csrf_token() }}">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('main.email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        @endif
                        @if(Route::currentRouteName()  == "password.reset")
                        @csrf
                        <form method="POST" action="{{ route('password.reset', ['token', request()->get('token')])  }} ">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="reset_token" value="{{ request()->get('token') }}">
                        <input type="hidden" name="email" value="{{ request()->get('email') }}">
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('main.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('main.ConfirmPassword') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        @endif

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('main.reset') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
