<title>{{ __('main.site_name')}}</title>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
window.onload = function(){
  $('#filter').val($.urlParam("filter"));
  $('#sort').val($.urlParam("sort"));
  if($.urlParam("femail") == true ) $('#femail').val($.urlParam("femail"));

}
</script>

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
        <div class="col-md-13">
            <div class="card">
                <div class="card-header">{{ __('main.Users') }}</div>
                    <div class="card-body">
                        <table class="table-data col-12">
                        <thead>
                            <form name="filter-search" action="/users" id="filter-search" method="GET">
                                @csrf
                                <tr>
                                    <th colspan="2">
                                        {{ __('main.FilterBy') }}
                                        <select id="filter" name="filter" onchange="$('#filter-search').submit();">
                                            <option value="id">{{ __('main.id') }}</option>
                                            <option value="created_at">{{__('main.created at')}}</option>
                                            <option value="email">{{ __('main.email') }}</option>
                                            <option value="name">{{ __('main.name') }}</option>
                                            <option value="role">{{ __('main.role') }}</option>
                                        </select>
                                    </th>
                                    <th colspan="1">
                                        {{ __('main.SortBy') }}
                                        <select id="sort" name="sort" onchange="$('#filter-search').submit();">
                                            <option value="ASC">{{ __('main.ASC') }}</option>
                                            <option value="DESC">{{ __('main.DESC') }}</option>
                                        </select>
                                    </th>
                                    <th colspan="3">
                                        <input type="text" id="femail"  name="femail" size="15"> 
                                        <input class="btn btn-primary" type="submit" value="{{ __('main.Search') }}">
                                        <a class="btn btn-danger" href="{{route("register")}}">Х</a>
                                    </th>
                                </tr>
                            </form>
                            <tr>
                                <th>{{ __('main.id') }}</th>
                                <th>{{ __('main.name') }}</th>
                                <th>{{ __('main.email') }}</th>
                                <th>{{ __('main.role') }}</th>
                                <th>{{ __('main.created at') }}</th>
                                <th>{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        @isset($users) 
                        <tr>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user['id']}}</td>
                                <td>{{$user['name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>{{$user['role']}}</td>
                                <td>{{$user['created_at']}}</td>
                                <td align=center>
                                    <div class="d-grid">
                                        <a href={{route('edit_user', ['user_id' => $user['id']]) }} class="btn btn-success">Изменить</a>
                                        <form method="post" action="{{route('delete_user')}}">
                                            @csrf
                                            <input name="id"  type="hidden" value="{{$user['id']}}" class="form-control">
                                            <a class="btn btn-danger"   onclick="$(`#delete-user{{$user['id']}}`).css('display', 'inline-block'); $(`#delete-user-cancel{{$user['id']}}`).css('display', 'inline-block');">{{__('main.delete')}}</a>
                                            <br>
                                            <input class="btn btn-danger" style="display:none" id="delete-user{{$user['id']}}" type="submit" value="{{__('main.yes')}}">
                                            <input type="button" value="{{__('main.no')}}" class="btn btn-secondary" style="display:none" id="delete-user-cancel{{$user['id']}}" onclick="$(`#delete-user-cancel{{$user['id']}}`).css('display', 'none'); $(`#delete-user{{$user['id']}}`).css('display', 'none'); ">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        
                        </tr>
                        <tr>
                            <td colspan="6" align="center">{{ $users->links() }}</td>
                        </tr>
                        @endisset
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

