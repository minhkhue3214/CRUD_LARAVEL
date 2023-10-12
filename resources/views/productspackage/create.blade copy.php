@extends('layout')

@section('content')
    {{-- @if ($errors->has('error'))
        <div id="danger-alert" class="alert alert-danger">{{ $errors->first('error') }}</div>
    @endif

    <script>
        setTimeout(function() {
            document.getElementById('danger-alert').style.display = 'none';
        }, 3000);
    </script> --}}


    @if ($errors->any())
        <div class="alert alert-danger text-center">
            Vui lòng kiểm tra lại dữ liệu
        </div>
    @endif

    <div class="container">
        <h1>Create Package Product</h1>
        <hr>

        <form action="{{ route('products.store') }}" method="POST" class="ms-auto me-auto mt-3" style="width: 500px"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleInputTitle" class="form-label">Product Package Name</label>
                <input type="text" name="title" class="form-control" placeholder="Enter your title"
                    value={{ old('title') }}>
                @error('title')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Description</label>
                {{-- <input type="text" name="description" class="form-control" placeholder="Enter your description"> --}}
                <textarea type="text" name="description" class="form-control" rows="5" id="comment"
                    placeholder="Enter your description">{{ old('description') }}</textarea>
                @error('description')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Thêm gói sản phẩm</button>
        </form>


        <div class="mb-3">
            <h2>Danh sách sản phẩm trong gói</h2>
        </div>

        <form action="{{ route('package.create') }}" style="width: 500px">
            <div class="form-group">
                <label for="sel1">Danh sách sản phẩm</label>
                <select class="form-control" id="sel1" name="selected_product">
                    @foreach ($products as $pr)
                        <option>{{ $pr->title }}</option>
                    @endforeach
                </select>
                <br>
            </div>
            <button type="submit" id="addProductBtn" class="btn btn-primary">Thêm sản phẩm vào gói</button>
        </form>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Mô tả sản phẩm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="productTable">
                @if (isset($listproducts) && $listproducts->count() > 0)
                    @foreach ($listproducts as $pr)
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

                    </tr>
                @endif
            </tbody>
        </table>

    </div>
@endsection
