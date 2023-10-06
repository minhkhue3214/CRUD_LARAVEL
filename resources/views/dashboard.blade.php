@extends('layout')

@section('content')
    <div class="container">

        <div class="d-flex">
            <h2>Quản lý sản phẩm</h2>
            <a type="button" class="btn btn-success" href="{{ url('products-create') }}">ADD PRODUCT</a>
        </div>

        <form action="{{ url('search') }}" method="GET" role="search" style="width: 500px">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search your product">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </div>
            </div>
        </form>

        {{-- @if (Session::has('success'))
            <div id="success-alert" class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('success-alert').style.display = 'none';
                }, 3000);
            </script>
        @endif --}}



        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá sản phẩm</th>
                    <th>Mã sản phẩm</th>
                    <th>Mô tả sản phẩm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($product->count() > 0)
                    @foreach ($product as $pr)
                        <tr>
                            <td>{{ $pr->title }}</td>
                            <td>{{ $pr->price }}</td>
                            <td>{{ $pr->product_code }}</td>
                            <td>{{ $pr->description }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    {{-- <a type="button" href="{{ route('products.destroy', $pr->id) }}" class="btn btn-success">DELETE</a>  --}}
                                    <form action="{{ route('products.destroy', $pr->id) }}" method="POST" type="button"
                                        class="btn btn-primary">
                                        <a type="button" href="{{ route('products.edit', $pr->id) }}"
                                            class="btn btn-success">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-0">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">Product not found</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <ul class="pagination">
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
        </ul>
    </div>
@endsection
