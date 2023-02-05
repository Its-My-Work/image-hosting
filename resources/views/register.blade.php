<title>{{ __('main.site_name')}}</title>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>


@includeif('layouts.top_menu')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            @includeif('layouts.status_card')
            <div class="card">
                <div class="card-header">{{ __('main.UserData') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ Request::url() }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('main.name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"  value="@isset($user_data['name']){{$user_data['name']}}@endisset" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('main.email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@isset($user_data['email']){{$user_data['email']}}@endisset" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('main.role') }}</label>

                            <div class="col-md-6">
                                <select id="role" name="role">
                                    <option value="user" @if (empty($user_data['role']) or $user_data['role']=="user") selected @endif>user</option>
                                    <option value = "admin" @if (!empty($user_data['role']) and $user_data['role']=="admin") selected @endif>admin</option>
                                </select>
                            </div>
                        </div>
                        @if(Route::is('edit_user'))
                            <div class="row mb-3 justify-content-center">
                                <div class="col-md-6">
                                    <label class="form-check-label" id="password_checkbox_text" for="password_checkbox">{{ __('main.ChangePassword') }}</label>                                
                                    <input onclick="$('#password').prop('disabled', !$('#password_checkbox').prop('checked'));$('#password-confirm').prop('disabled', !$('#password_checkbox').prop('checked'));" class="password_checkbox" type="checkbox" name="" id="password_checkbox">
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('main.password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" @if(Route::is('edit_user')) disabled @endif>
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
                                <input id="password-confirm" data-onload="alert()" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" @if(Route::is('edit_user')) disabled @endif>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                @if(Route::is('edit_user'))
                                    <button type="submit" class="btn btn-primary"> {{ __('main.EditUser') }}</button>
                                    <a href = "{{ route('register') }}"  class="btn btn-primary">{{ __('main.Cancel') }}</a>
                                @else 
                                    <button type="submit" class="btn btn-primary"> {{ __('main.RegisterUser') }}</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('main.Users') }}</div>
                    <div class="card-body">
                        <table class="table-data">
                        <thead>
                            <tr>
                                <th>{{ __('main.id') }}</th>
                                <th>{{ __('main.name') }}</th>
                                <th>{{ __('main.email') }}</th>
                                <th>{{ __('main.role') }}</th>
                                <th>{{ __('main.created at') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tr>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user['id']}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>{{$user['role']}}</td>
                                <td>{{$user['created_at']}}</td>
                                <td>
                                    <div class="d-grid col-6">
                                        <a href={{route('edit_user', ['user_id' => $user['id']]) }} class="btn btn-success">Изменить</a>
                                        <form method="post" action="{{route('delete_user')}}">
                                            @csrf
                                            <input name="id"  type="hidden" value="{{$user['id']}}" class="form-control">
                                            <input class="btn btn-danger" type="submit" value="{{__('main.delete')}}">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="6" align="center">{{ $users->links() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

