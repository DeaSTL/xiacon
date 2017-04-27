<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php echo script('jquery-3.2.0.min.js'); ?>

        <?php echo script('bootstrap.min.js'); ?>

        <?php echo script('function_lib.js'); ?>

        <?php echo style('bootstrap.min.css'); ?>

        <?php echo style('navbar.css'); ?>

        <title>xiacon</title>
    </head>
    <body>
        <nav class="navbar navbar-custom">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nbcol" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php echo link_to('/', 'Xiacon', ['class' => 'navbar-brand']); ?>

                </div>

                <div class="collapse navbar-collapse" id="nbcol">
                    <ul class="nav navbar-nav">
                        
                    </ul>
                    <form action="#" class="navbar-form navbar-left">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" id="search_bar">
                        </div>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        
                    </ul>
                </div>
            </div>
        </nav>
        <?php echo $__env->yieldContent('content'); ?>
    </body>
</html>
