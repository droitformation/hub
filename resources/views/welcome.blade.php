<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">

            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <a class="navbar-brand" href="#">Hub</a>
                                </div>
                                @if (!Auth::check())
                                    <div class="btn-group pull-right">
                                        <a href="{{ url('login/droithub')}}" class="btn btn-info navbar-btn">login par droithub</a>
                                    </div>
                                @endif
                                @if (Auth::check())
                                    <p class="navbar-text navbar-right">Bonjour {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} &nbsp;</p>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>

                <div class="title">Laravel 5</div>
            </div>
        </div>
    </body>
</html>
