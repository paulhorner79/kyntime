<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Error</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,300" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #b12025;
                color: #fafaf6;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }
            p {
                margin: 32px 0;
            }
            .title {
                font-size: 84px;
                font-weight: 300;
            }

            .info {
                font-size: 24px;
            }
            a {
                color: #fafaf6;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    @yield('code')
                </div>
                <div class="info">
                    @yield('msg')
                    <p>
                        <a href="/">Click here</a> to return home.
                    </p>
                </div>
            </div>
        </div>
        @include("layout/analytics")
    </body>
</html>
