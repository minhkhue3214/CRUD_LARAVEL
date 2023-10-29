<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <script src="../../views/home/home.js"></script> --}}

    <title>Trang chủ</title>
</head>



<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Giỏ hàng
                    </button>
                </ul>
                <span class="navbar-text">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @guest
                            <li class="nav-item">
                                <a href="{{ url('register') }}" class="nav-link active" aria-current="page">Register</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('login') }}" class="nav-link">Login</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ url('user-logout') }}" class="nav-link">Logout</a>
                            </li>
                        @endguest
                    </ul>
                </span>
            </div>
        </div>
    </nav>

    @if ($errors->has('error'))
        <div id="danger-alert" class="alert alert-danger">{{ $errors->first('error') }}</div>
    @endif

    <h1>Danh sách các sản phẩm</h1>
    <div class="d-flex flex-wrap">
        @if ($products->count() > 0)
            @foreach ($products as $pr)
                <div class="p-2 bd-highlight">
                    <figure class="figure">
                        <img src="{{ $pr->image }}" class="figure-img img-fluid rounded"
                            style="width: 200px; height: 150px;" alt="...">
                        <figcaption class="figure-caption">Tên: {{ $pr->title }}</figcaption>
                        <figcaption class="figure-caption">Giá: {{ $pr->price }}.</figcaption>
                        {{-- <button type="button" class="btn btn-primary">Mua</button> --}}
                        <a type="button" class="btn btn-primary save-product"
                            data-product="{{ json_encode($pr) }}">Mua</a>
                    </figure>
                </div>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">Product not found</td>
            </tr>
        @endif
    </div>

    <h1>Danh sách gói sản phẩm</h1>
    <div class="d-flex flex-wrap">
        @if ($packages->count() > 0)
            @foreach ($packages as $pk)
                <div class="p-2 bd-highlight">
                    <figure class="figure">
                        <img src="{{ $pk->image }}" class="figure-img img-fluid rounded"
                            style="width: 200px; height: 150px;" alt="...">
                        <figcaption class="figure-caption">Tên: {{ $pk->name }}</figcaption>
                        <figcaption class="figure-caption">Mô tả: {{ $pk->description }}.</figcaption>
                        <a type="button" class="btn btn-primary save-package"
                            data-package="{{ json_encode($pk) }}">Mua</a>
                    </figure>
                </div>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="5">Package not found</td>
            </tr>
        @endif
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Giỏ hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('home.payment') }}" method="POST" class="ms-auto me-auto mt-3"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <h1>Sản phẩm</h1>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Giá sản phẩm</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-product">

                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="modal-body">
                        @if ((isset($productcart) && count($productcart) > 0) || (isset($packagecart) && count($packagecart) > 0))
                            @if (isset($productcart) && count($productcart) > 0)
                                <h1>Sản phẩm</h1>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tên sản phẩm</th>
                                            <th scope="col">Giá sản phẩm</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productcart as $product)
                                            <tr>
                                                <th scope="row">{{ $product->id }}</th>
                                                <td>{{ $product->title }}</td>
                                                <td>{{ $product->price }}</td>
                                                <input type="hidden" value="{{ $product->price }}" name="price[]">
                                                <td>
                                                    <input name="quantity_product[]" type="number" class="form-control"
                                                        value={{ $product->quantity }} placeholder="quantity"
                                                        aria-describedby="basic-addon1"
                                                        style="width: 120px; height: 30px;">
                                                </td>
                                                <td> <a type="button"
                                                        href="{{ route('home.deleteproduct', $product->id) }}"
                                                        class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            @endif

                            @if (isset($packagecart) && count($packagecart) > 0)
                                <h1>Gói sản phẩm</h1>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tên gói sản phẩm</th>
                                            <th scope="col">Giá gói sản phẩm</th>
                                            <th scope="col">Số lượng</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packagecart as $package)
                                            <tr>
                                                <th scope="row">{{ $package->id }}</th>
                                                <td>{{ $package->name }}</td>
                                                <td>{{ $package->price }}</td>
                                                <input type="hidden" value="{{ $package->price }}" name="price[]">
                                                <td> <input name="quantity_package[]" type="number"
                                                        class="form-control" value={{ $package->quantity }}
                                                        placeholder="quantity" aria-describedby="basic-addon1"
                                                        style="width: 120px; height: 30px;">
                                                </td>
                                                <td> <a type="button" class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            @endif
                            <button type="submit" class="btn btn-primary">Thanh toán</button>
                        @else
                            <h3>Không có sản phẩm nào trong giỏ hàng</h3>
                        @endif

                    </div> --}}
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .product-list {
            display: flex;
            flex-wrap: wrap;
        }
    </style>

    <script>
        let testing = "khue"
        let productList = JSON.parse(localStorage.getItem('productList')) || [];
        let packageList = JSON.parse(localStorage.getItem('packageList')) || [];

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('save-product')) {
                e.preventDefault();
                console.log("productList", productList);


                const productData = e.target.getAttribute('data-product');
                const product = JSON.parse(productData);
                let targetID = product.id;

                var isIDExists = productList.some(function(product) {
                    return product.id === targetID;
                });

                if (isIDExists) {
                    alert("sản phẩm đã tồn tại trong giỏ hàng")
                } else {
                    const tbody = document.querySelector('.tbody-product');

                    product.quantity = 1;
                    console.log("testing product", JSON.stringify(product));
                    productList.push(product);

                    localStorage.setItem('productList', JSON.stringify(productList));
                }

            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('save-package')) {
                e.preventDefault();

                console.log("packageList", packageList);


                const packageData = e.target.getAttribute('data-package');
                const package = JSON.parse(packageData);
                let targetID = package.id;

                var isIDExists = packageList.some(function(package) {
                    return package.id === targetID;
                });

                if (isIDExists) {
                    alert("gói sản phẩm đã tồn tại trong giỏ hàng")
                } else {
                    package.quantity = 1;
                    console.log("testing package", JSON.stringify(package));
                    packageList.push(package);
                    localStorage.setItem('packageList', JSON.stringify(packageList));

                    // Lấy dữ liệu từ LocalStorage
                    var dataFromLocalStorage = localStorage.getItem(
                        'packageList'); // Thay 'keyName' bằng tên key của bạn

                    // Sử dụng AJAX để gửi dữ liệu đến máy chủ PHP
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'url_của_php_script.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    console.log("dataFromLocalStorage", dataFromLocalStorage);
                    // Gửi dữ liệu như một tham số POST
                    xhr.send('data=' + dataFromLocalStorage);
                }

            }
        });
    </script>







    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
