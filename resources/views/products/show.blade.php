@extends('layout')

@section('content')
    <div class="container">
        <h1>Detail Product</h1>
        <hr>
        <div class="mb-3">
            <label for="exampleInputTitle" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $product->title }}"
                placeholder="Enter your title">
        </div>
        <div class="mb-3">
            <label for="exampleInputPrice" class="form-label">Price</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}"
                placeholder="Enter your price">
        </div>
        <label for="exampleInputPrice" class="form-label">Image</label>
        <div class="mb-3" style="flex">
            <img src="{{ $product->image }}" width="150" height="150" alt="">
        </div>
        <div class="mb-3">
            <label for="exampleInputPrice" class="form-label">Product code</label>
            <input type="text" name="product_code" class="form-control" value="{{ $product->product_code }}"
                placeholder="Enter your product code">
        </div>
        <div class="mb-3">
            <label for="exampleInputPrice" class="form-label">Description</label>
            <textarea type="text" name="description" class="form-control" rows="5" id="comment"
                placeholder="Enter your description">{{ $product->description }}</textarea>
        </div>
    </div>
@endsection
