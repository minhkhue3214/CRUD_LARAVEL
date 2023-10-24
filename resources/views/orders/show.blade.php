@extends('layout')

@section('content')
    <div class="container">
        <h1>Chi tiết đơn hàng</h1>
        <hr>
        <div class="mb-3">
            <label for="exampleInputTitle" class="form-label">Mã khách hàng</label>
            <input type="text" name="title" class="form-control" value="{{ $order->user_id }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputTitle" class="form-label">Tên khách hàng</label>
            <input type="text" name="title" class="form-control" value="{{ $order->user_name }}">
        </div>
        <div class="mb-3">
            <label for="exampleInputPrice" class="form-label">Tổng giá đơn hàng</label>
            <input type="text" name="price" class="form-control" value="{{ $order->price }}">
        </div>

        @if (isset($productcart) && count($productcart) > 0)
            <h2>Danh sách sản phẩm đã thanh toán</h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá sản phẩm</th>
                        <th>Mã sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Mô tả sản phẩm</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productcart as $product)
                        <tr>
                            <th scope="row">{{ $product->id }}</th>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->product_code }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        @endif

        @if (isset($packagecart) && count($packagecart) > 0)
            <h2>Gói sản phẩm đã thanh toán</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên gói sản phẩm</th>
                        <th scope="col">Giá gói sản phẩm</th>
                        <th scope="col">Số lượng</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($packagecart as $package)
                        <tr>
                            <th scope="row">{{ $package->id }}</th>
                            <td>{{ $package->name }}</td>
                            <td>{{ $package->name }}</td>
                            <td>{{ $package->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        @else
        @endif
    </div>
@endsection
