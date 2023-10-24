<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="navbar-brand" href="{{ route('products.index') }}">PRODUCT MANAGEMENT</a>
                    <a class="navbar-brand" href="{{ route('packages.index') }}">PACKAGING MANAGEMENT</a>
                    <a class="navbar-brand" href="{{ route('home.orders') }}">ORDER MANAGEMENT</a>
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
                                <a href="{{ url('logout') }}" class="nav-link">Logout</a>
                            </li>
                        @endguest
                    </ul>
                </span>
            </div>
        </div>
    </nav>

    <h1>Danh sách các sản phẩm</h1>
    <div class="d-flex flex-wrap">
        @if ($products->count() > 0)
            @foreach ($products as $pr)
                <div class="p-2 bd-highlight">
                    <figure class="figure">
                        <img src="https://game8.vn/media/202201/images/hp/haku-la-anh-trai-qua-co-cua-chihiro-4.jpg"
                            class="figure-img img-fluid rounded" style="width: 200px; height: 150px;" alt="...">
                        <figcaption class="figure-caption">Tên: {{ $pr->title }}</figcaption>
                        <figcaption class="figure-caption">Giá: {{ $pr->price }}.</figcaption>
                        {{-- <button type="button" class="btn btn-primary">Mua</button> --}}
                        <a type="button" href="{{ route('home.insertproduct', $pr->id) }}"
                            class="btn btn-primary">Mua</a>
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
                        <img src="https://d.newsweek.com/en/full/1920025/cat-its-mouth-open.jpg?w=1600&h=1600&q=88&f=b7a44663e082b8041129616b6b73328d"
                            class="figure-img img-fluid rounded" style="width: 200px; height: 150px;" alt="...">
                        <figcaption class="figure-caption">Tên: {{ $pk->name }}</figcaption>
                        <figcaption class="figure-caption">Giá: {{ $pk->description }}.</figcaption>
                        <a type="button" href="{{ route('home.insertpackage', $pk->id) }}"
                            class="btn btn-primary">Mua</a>
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
                                            {{-- <input type="hidden" value="{{ $product->id }}" name="id[]"> --}}
                                            <td>{{ $product->title }}</td>
                                            {{-- <input type="hidden" value="{{ $product->title }}" name="title[]"> --}}
                                            <td>{{ $product->price }}</td>
                                            <input type="hidden" value="{{ $product->price }}" name="price[]">
                                            <td>
                                                <input name="quantity_product[]" type="number" class="form-control"
                                                    value={{ $product->quantity }} placeholder="quantity"
                                                    aria-describedby="basic-addon1" style="width: 120px; height: 30px;">
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
                            <h1>carts không có sản phẩm nào</h1>
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
                                @foreach ($packagecart as $package)
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $package->id }}</th>
                                            {{-- <input type="hidden" value="{{ $package->id }}" name="id[]"> --}}
                                            <td>{{ $package->name }}</td>
                                            {{-- <input type="hidden" value="{{ $package->name }}" name="name[]"> --}}
                                            <td>{{ $package->price }}</td>
                                            <input type="hidden" value="{{ $package->price }}" name="price[]">
                                            <td> <input name="quantity_package[]" type="number" class="form-control"
                                                    value={{ $package->quantity }} placeholder="quantity"
                                                    aria-describedby="basic-addon1"
                                                    style="width: 120px; height: 30px;">
                                            </td>
                                            <td> <a type="button"
                                                    href="{{ route('home.deletepackage', $package->id) }}"
                                                    class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        @else
                            <h1>carts không có gói sản phẩm nào</h1>
                        @endif

                    </div>
                    <button type="submit" class="btn btn-primary">Thanh toán</button>
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
