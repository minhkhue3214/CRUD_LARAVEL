<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                                <a href="{{ url('user-login') }}" class="nav-link">Login</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ url('user-logout') }}" class="nav-link" id="logout-link">Logout</a>
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
                        <figcaption class="figure-caption">Giá: {{ $pk->price }}</figcaption>
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
                    <h4>Sản phẩm</h4>
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
                            <!-- Dữ liệu sản phẩm từ localStorage sẽ được hiển thị ở đây -->
                        </tbody>
                    </table>

                    <h4>Gói sản phẩm</h4>
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
                        <tbody class="tbody-package">
                            <!-- Dữ liệu gói sản phẩm từ localStorage sẽ được hiển thị ở đây -->
                        </tbody>
                    </table>

                    <h6 id="totalPrice">Tổng tiền cần thanh toán: </h6>

                    @guest
                        <h6>Đăng nhập để tiến hành thanh toán</h6>
                    @else
                        <button type="button" onclick="Payment()" class="btn btn-secondary"
                            data-bs-dismiss="modal">Payment</button>
                    @endguest

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
    <script src="/home.js"></script>


</body>

</html>
