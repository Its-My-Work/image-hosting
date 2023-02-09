<title>{{ __('main.site_name')}}</title>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script src="{{ asset('js/BigPicture.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script>
window.onload = function(){
  $('#filter').val($.urlParam("filter"));
  $('#sort').val($.urlParam("sort"));
}
</script>
@includeif('layouts.top_menu')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @includeif('layouts.status_card')
            <div class="card">
                <div class="card-header">{{ __('main.Upload Images') }}</div>
                <div class="card-body">
                    <!-- форма загрузки изображений-->
                    <form method="post" action="{{ route('home') }}" enctype="multipart/form-data" >
                        @csrf              <!-- защита от XSS-->
                        <input type="file" name="images[]" multiple required>
                        <input type="submit">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('main.Galleries') }}</div>
                <div class="card-body">
                    <table class="table-data col-12">
                        <thead>
                        <form name="filter-search" action="/home" id="filter-search" method="GET">
                                @csrf
                                <tr>
                                    <th colspan="2">
                                        {{ __('main.FilterBy') }}
                                        <select id="filter" name="filter" onchange="$('#filter-search').submit();">
                                            <option value="id">{{ __('main.id') }}</option>
                                            <option value="created_at">{{__('main.created_at')}}</option>
                                        </select>
                                    </th>
                                    <th colspan="2">
                                        {{ __('main.SortBy') }}
                                        <select id="sort" name="sort" onchange="$('#filter-search').submit();">
                                            <option value="ASC">{{ __('main.ASC') }}</option>
                                            <option value="DESC">{{ __('main.DESC') }}</option>
                                        </select>
                                    </th>
                                    
                                </tr>
                            </form>
                        <tr>
                            <th>{{ __('main.id') }}</th>
                            <th>{{ __('main.Images') }}</th>
                            <th>{{ __('main.created_at') }}</th>
                            <th>{{ __('main.Link') }}</th>
                        </tr>
                        </thead>
                        @foreach ($galleries as $image) 
                            <tr>
                                <td>{{ $image->id }}</td>
                                    @php
                                        $files = explode('!', $image['file']);
                                        array_pop($files);
                                    @endphp
                                <td>
                                    @foreach($files as $file) <img  src={{ URL::asset("storage/$file") }} class="img-thumbnail" onclick="BigPicture({el: this, imgSrc: '/storage/{{$file}}'})" width="100px">
                                    @endforeach
                                </td>
                                <td>{{ $image->created_at }}</td>
                                <td>
                                    <a href={{route('index', ['gallery_id' => $image->id]) }} class="btn btn-primary">{{ __('main.open') }}</a><br>
                                    <a href={{route('delete_gallery', ['gallery_id' => $image->id]) }} class="btn btn-danger">{{ __('main.delete') }}</a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" align="center">{{ $galleries->links() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
