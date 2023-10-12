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
        {{-- @php
            // dd($errors);
            dd($errors->all());
        @endphp --}}
        {{-- <div class="alert alert-danger text-center">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div> --}}
        <div class="alert alert-danger text-center">
            Vui lòng kiểm tra lại dữ liệu
        </div>
    @endif

    <div class="container">
        <h1>Create Product</h1>
        <hr>

        <form action="{{ route('products.store') }}" method="POST" class="ms-auto me-auto mt-3" style="width: 500px"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="exampleInputTitle" class="form-label">Product Name</label>
                <input type="text" name="title" class="form-control" placeholder="Enter your title"
                    value={{ old('title') }}>
                @error('title')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Price</label>
                <input type="number" name="price" class="form-control" placeholder="Enter your price"
                    value={{ old('price') }}>
                @error('price')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPrice" class="form-label">Product code</label>
                <input type="text" name="product_code" class="form-control" placeholder="Enter your product code"
                    value={{ old('product_code') }}>
                @error('product_code')
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
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
