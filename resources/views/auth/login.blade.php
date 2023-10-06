    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-2">
                    <h2>Login Page</h2>


                    {{-- @if (Session::has('error'))
                        <div id="danger-alert" class="alert alert-danger" role="alert">
                            {{ $errors->first('error') }}
                        </div>
                        <script>
                            setTimeout(function() {
                                document.getElementById('danger-alert').style.display = 'none';
                            }, 5000); // 5000 milliseconds (5 giây)
                        </script>
                    @endif --}}


                    @if ($errors->has('error'))
                        <div id="danger-alert" class="alert alert-danger">{{ $errors->first('error') }}</div>
                    @endif

                    <script>
                        setTimeout(function() {
                            document.getElementById('danger-alert').style.display = 'none';
                        }, 3000); 
                    </script>


                    <form method="post" action="{{ route('login.post') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4">Email</label>
                            <div class="col-md-8">
                                <input type="text" name="email" class="form-control"
                                    placeholder="Enter your email">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4">Password</label>
                            <div class="col-md-8">
                                <input type="text" name="password" class="form-control"
                                    placeholder="Enter your password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8">
                                <input type="submit" name="submit" class="btn btn-success" placeholder="Submit">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </body>

    </html>
