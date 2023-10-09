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
      <a class="navbar-brand" href="{{ route('products') }}">PRODUCT MANAGEMNT</a>
    </div>

    <ul class="nav navbar-nav navbar-right">

      @guest
      <li><a href="{{ url('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      @else          
      <li><a href="{{ url('logout') }}"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>          
      @endguest

    </ul>
  </div>
</nav>
 @yield("content")

</body>
</html>
