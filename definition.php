<?php require_once __DIR__.'/init.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <?=script('jquery-3.2.0.min.js')?> 
        <?=script('bootstrap.min.js')?> 
        <?=script('function_lib.js')?> 
        <?=style('bootstrap.min.css')?> 
        <?=style('navbar.css')?> 
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
                    <a class="navbar-brand" href="<?=link_to('/')?>">Xiacon</a>
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
        <div id="search_output">
            <?php

            $db = new Core\Database();

            if (isset($_GET['q'])) {
                $db->select('entries', ['word', '=', $_GET['q']]);

                if ($db->count()) {
                    foreach ($db->all() as $item) {
                        $word = $item->word;
                        $def = $item->definition;
                        $content = <<<EOF
<div class="panel panel-primary"><div class="panel-heading">$word</div><div class="panel-body">$def</div></div>
EOF;
                        
                        echo $content;
                    }
                } else {
                    echo 'The requested word was not found in the database!';
                }
            }

            ?>
        </div>
    </body>
</html>
