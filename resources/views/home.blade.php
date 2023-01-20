@extends('layouts.app')

@section('content')

@php if(count($errors)>0) $message = __('Only images!');
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! nl2br($message) !!}
                    
                </div>
            </div>

            <div class="card">
                <div class="card-header">{{ __('Upload Images') }}</div>
                <div class="card-body">
                    <!-- форма загрузки изображений-->
                    <form method="post" enctype="multipart/form-data" >
                        @csrf              <!-- защита от XSS-->
                        <input type="file" name="images[]" multiple>
                        <input type="submit">
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Uploaded Galleries') }}</div>
                <div class="card-body">
                    <table align=center>
                        <tr>
                            <td>ID</td>
                            <td>Images</td>
                            <td>Link</td>
                        </tr>
                        @foreach ($galleries as $image) 
                            <tr>
                                <td>{{ $image->id }}</td>
                                    @php
                                        $files = explode('!', $image['file']);
                                        array_pop($files);
                                    @endphp
                                <td>
                                    @foreach($files as $file) <a href='/storage/{{ $file }}'><img src='/storage/{{ $file}} ' class='galery' width=100px></a>
                                    @endforeach
                                </td>
                                <td><a href={{route('delete', ['gallery_id' => $image->id]) }}>Удалить</a></td>
                            </tr>
                            <br>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
