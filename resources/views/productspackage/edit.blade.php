<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title></title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('products') }}">PRODUCT MANAGEMNT</a>
                <a class="navbar-brand" href="{{ route('products.package') }}">PACKAGING MANAGEMET</a>
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

    <div class="container">
        <h1>Edit Package Product</h1>
        <hr>

        <form action="{{ route('package.update', $package->id) }}" method="POST" class="ms-auto me-auto mt-3"
            style="width: 1000px" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="exampleInputTitle" class="form-label">Product Package Name</label>
                <input type="text" name="package_name" class="form-control" placeholder="Enter your title"
                    value="{{ $package->package_name }}">
                @error('package_name')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Description</label>
                {{-- <input type="text" name="description" class="form-control" placeholder="Enter your description"> --}}
                <textarea type="text" name="package_description" class="form-control" rows="5" id="comment"
                    placeholder="Enter your description">{{ $package->package_description }}</textarea>
                @error('package_description')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <h2>Danh sách sản phẩm trong gói</h2>
            </div>

            <div class="wrapper">
                @error('product_list')
                    <span style="color:red">{{ $message }}</span>
                @enderror
                <div id="itemForm">
                    @foreach ($products as $pr)
                        <div class="item">
                            <label for="green">{{ $pr->title }}</label>
                            <input name="product_list[]" @if (in_array($pr->id, $productIds)) checked @endif
                                id={{ $pr->id }} type="checkbox" value="{{ $pr->id }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Sửa gói sản phẩm</button>
        </form>
    </div>


</body>

</html>

<style>
    .header {
        text-align: center;
        background-color: rgb(68, 25, 211);
        color: white;
        padding: 10px;
    }

    .wrapper {
        width: 20%;
        margin: auto;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgb(54, 54, 54);
        overflow: hidden;
    }

    .item {
        padding: 10px;
        margin-left: 40px;
    }

    button {
        display: block;
        margin: 10px auto;
        outline: none;
        padding: 12px;
        border: none;
        background-color: rgb(68, 25, 211);
        border-radius: 8px;
        color: white;
        cursor: pointer;
        width: 150px;
    }

    .result {
        text-align: center;
        margin-top: 20px;
    }
</style>

<script>
    var itemForm = document.getElementById('itemForm'); // getting the parent container of all the checkbox inputs
    var checkBoxes = itemForm.querySelectorAll('input[type="checkbox"]'); // get all the check box
    document.getElementById('submit').addEventListener('click', getData); //add a click event to the save button

    let result = [];

    function getData() { // this function will get called when the save button is clicked
        result = [];
        checkBoxes.forEach(item => { // loop all the checkbox item
            if (item.checked) { //if the check box is checked
                let data = { // create an object
                    item: item.value,
                    selected: item.checked
                }
                result.push(data); //stored the objects to result array
            }
        })
        document.querySelector('.result').textContent = JSON.stringify(result); // display result
    }
</script>
