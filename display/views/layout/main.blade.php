<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        {!! script('jquery-3.2.0.min.js') !!}
        {!! script('bootstrap.min.js') !!}
        {!! script('function_lib.js') !!}
        {!! style('bootstrap.min.css') !!}
        {!! style('navbar.css') !!}
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
                    {!! link_to('/', 'Xiacon', ['class' => 'navbar-brand']) !!}
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
        @yield('content')
    </body>
</html>
