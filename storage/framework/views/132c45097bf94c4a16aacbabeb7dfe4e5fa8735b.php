
<html lang="en"><head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Landing Page - Start Bootstrap Theme</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo e(asset("css/bootstrap.min.css")); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo e(asset("css/landing-page.min.css")); ?>" rel="stylesheet">
 
    <body class="" style="">

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#">Хостинг Картинок</a>
            <div>
                <?php echo $menu; ?>

            </div>
        </div>
    </nav>

    <!-- Masthead -->
    <header class="masthead text-white text-center" style="">
        <div class="overlay" contenteditable="true"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5">Введите ID ссылки для просмотра изображений</h1>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form method="get">
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0">
                                <input type="text" name="id" class="form-control form-control-lg" placeholder="<?php echo e(__('Enter galery ID!')); ?>">
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-block btn-lg btn-primary"><?php echo e(__('Open galery!')); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Icons Grid -->


    <!-- Image Showcases -->
 
    
    
    
    
    <section class="features-icons bg-light text-center center-block" style="max-width: none; max-height: none; width: 100%; height: 249.812px">

      <?php echo $message; ?>



   
    </section>

<?php /**PATH /var/www/admin/data/www/laravel.xn----7sbajlcc7cwa1af2d.xn--p1ai/image-hosting/resources/views/welcome.blade.php ENDPATH**/ ?>