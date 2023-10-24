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
                <h2>Register Page</h2>

                @if ($errors->has('error'))
                    <div id="danger-alert" class="alert alert-danger">{{ $errors->first('error') }}</div>
                @endif

                <script>
                    setTimeout(function() {
                        document.getElementById('danger-alert').style.display = 'none';
                    }, 3000);
                </script>


                <form method="post" action="{{ route('register.post') }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-4">Name</label>
                        <div class="col-md-8">
                            <input type="text" name="name" class="form-control"
                                placeholder="Enter your name">
                            @error('name')
                                <span style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Email</label>
                        <div class="col-md-8">
                            <input type="email" name="email" class="form-control"
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
                        <label class="col-md-4">Retype Password</label>
                        <div class="col-md-8">
                            <input type="password" name="repassword" class="form-control"
                                placeholder="Reenter your password">
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
