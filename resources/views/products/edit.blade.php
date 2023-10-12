@extends('layout')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger text-center">
            Vui lòng kiểm tra lại dữ liệu chỉnh sửa
        </div>
    @endif
    <div class="container">
        <h1>Edit page</h1>
        <hr>
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="ms-auto me-auto mt-3"
            style="width: 500px" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="exampleInputTitle" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ $product->title }}"
                    placeholder="Enter your title">
                @error('title')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Price</label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}"
                    placeholder="Enter your price">
                @error('price')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Product code</label>
                <input type="text" name="product_code" class="form-control" value="{{ $product->product_code }}"
                    placeholder="Enter your product code">
                @error('product_code')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Description</label>
                <textarea type="text" name="description" class="form-control" rows="5" id="comment"
                    placeholder="Enter your description">{{ $product->description }}</textarea>
                @error('description')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
