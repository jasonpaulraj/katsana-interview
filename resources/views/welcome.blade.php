<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
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

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    
                </div>

                <div class='col-12'>
                <div class="card-body">
                <form method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                        <div class="col-6">
                            <label>Select json file to upload:</label>
                            </div>
                            <div class="col-6">
                            <input type='file' name='filename' id='filename'>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   Upload
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </form>
            <br>
                <div class="links">
                    @if(session()->get('filename'))
                    @php($uploaded_file = session()->get('filename'))
                    @php($download_path = session()->get('download_path'))
                    <p style='width:100%'>{{$uploaded_file}} uploaded successfully!</p>
                    <br>
                    <a href='{{$download_path}}'>Download as CSV</a>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
