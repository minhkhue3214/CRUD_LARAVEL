@extends('layout')

@section('content')
    <div class="container">
        <h1>Detail Package Product</h1>
        <hr>
        <div class="mb-3">
            <label for="exampleInputTitle" class="form-label">Tên gói sản phẩm</label>
            <input type="text" name="title" class="form-control" value="{{ $package->name }}"
                placeholder="Enter your title">
        </div>
        <div class="mb-3">
            <label for="exampleInputPrice" class="form-label">Mô tả gói sản phẩm</label>
            <input type="text" name="price" class="form-control" value="{{ $package->description }}"
                placeholder="Enter your price">
        </div>
        <h2>Danh sách sản phẩm trong gói</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Mô tả sản phẩm</th>
                </tr>
            </thead>
            <tbody>
                @if ($products->count() > 0)
                    @foreach ($products as $pr)
                        <tr>
                            <td>{{ $pr->id }}</td>
                            <td>{{ $pr->title }}</td>
                            <td>{{ $pr->price }}</td>
                            <td>{{ $pr->product_code }}</td>
                            <td>{{ substr($pr->description, 0, 60) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">Product not found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>


@endsection
