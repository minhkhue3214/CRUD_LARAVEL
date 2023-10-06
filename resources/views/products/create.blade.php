<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>Create Post</h1>
        <form action="{{ route('products.store') }}" method="POST" class="ms-auto me-auto mt-3" style="width: 500px"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleInputTitle" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter your title">
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Price</label>
                <input type="text" name="price" class="form-control" placeholder="Enter your price">
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Product code</label>
                <input type="text" name="product_code" class="form-control" placeholder="Enter your product code">
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Description</label>
                <input type="text" name="description" class="form-control" placeholder="Enter your description">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>

</html>
