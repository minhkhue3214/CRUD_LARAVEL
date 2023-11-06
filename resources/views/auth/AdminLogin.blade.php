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
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                </div>
                <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ url('admin-form') }}"><span class="glyphicon glyphicon-log-in"></span>Admin Register</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-2">
                    <h2>Dashboard Page</h2>

                    @if ($errors->has('error'))
                        <div id="danger-alert" class="alert alert-danger">{{ $errors->first('error') }}</div>
                    @endif

                    <script>
                        setTimeout(function() {
                            document.getElementById('danger-alert').style.display = 'none';
                        }, 3000);
                    </script>


                    <form method="POST" action="{{ route('admin.dashboard') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-4">Email</label>
                            <div class="col-md-8">
                                <input type="text" name="email" class="form-control"
                                    placeholder="Enter your email">
                                @error('email')
                                    <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4">Password</label>
                            <div class="col-md-8">
                                <input type="password" name="password" class="form-control"
                                    placeholder="Enter your password">
                                @error('password')
                                    <span style="color:red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8">
                                <button type="submit" name="submit" class="btn btn-success">Login</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </body>

    </html>
