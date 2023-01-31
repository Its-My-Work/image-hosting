
<html lang="ru">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ __('main.site_name')}}</title>


    <!-- Custom styles for this template -->
    <link href="{{ asset('css/landing-page.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/BigPicture.min.js') }}"></script>
 
    <body class="" style="">
    @includeif('layouts.top_menu')
    <!-- Masthead -->
    <header class="masthead text-white text-center" style="">
        
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5">{{ __('main.enter_gallery_id')}}</h1>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form method="get">
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0">
                                <div class="input-group">
                                    <input type="input" maxlength="8" onkeypress="return isNumber(event)" onpaste="return false;" name="gallery_id" class="form-control form-control-lg" placeholder="{{ __('main.id')}}" required>
                                    <button type="submit" class="btn btn-block btn-lg btn-primary">{{ __('main.show_gallery')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="container">
                </div>
            </div>
        </div>
    </header>

    
    <section class="features-icons bg-light text-center center-block" style="max-width: none; max-height: none; width: 100%; height: 249.812px">
      {!! $message !!}
    </section>
    </body>
</html>
