<title>{{ __('main.site_name')}}</title>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script src="{{ asset('js/BigPicture.min.js') }}"></script>
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
                    <table class="table-data">
                        <thead>
                        <tr>
                            <th>{{ __('main.id') }}</th>
                            <th>{{ __('main.Images') }}</th>
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
                                    @foreach($files as $file) <img  src="/storage/{{ $file}}" class="img-thumbnail" onclick="BigPicture({el: this, imgSrc: '/storage/{{$file}}'})" width="100px">
                                    @endforeach
                                </td>
                                <td>
                                    <a href={{route('index', ['gallery_id' => $image->id]) }} class="btn btn-primary">{{ __('main.open') }}</a><br>
                                    <a href={{route('delete_gallery', ['gallery_id' => $image->id]) }} class="btn btn-danger">{{ __('main.delete') }}</a>
                                </td>
                            </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
