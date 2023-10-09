@extends('layout')

@section('content')
    <div class="container">

        <div class="flex-row">
            <h2>Quản lý sản phẩm</h2>
        </div>

        {{-- <form action="{{ url('search') }}" type="get" role="search" style="width: 500px">
            <div class="input-group">
                <input type="search" class="form-control" name="query" placeholder="Search your product">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </div>
            </div>
        </form> --}}

        <form action="" class="col-9">
            <div class="input-group">
                <input type="search" name="search" style="width: 500px" id="" class="form-control"
                    placeholder="Search by name" value="{{ $search }}">
                <button class="btn btn-primary">Search</button>
                <a type="button" class="btn btn-success" href="{{ url('products-create') }}">ADD PRODUCT</a>
            </div>
        </form>

        @if (Session::has('success'))
            <div id="success-alert" class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('success-alert').style.display = 'none';
                }, 3000);
            </script>
        @endif



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
                @if ($products->count() > 0)
                    @foreach ($products as $pr)
                        <tr>
                            <td>{{ $pr->title }}</td>
                            <td>{{ $pr->price }}</td>
                            <td>{{ $pr->product_code }}</td>
                            <td>{{ $pr->description }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
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

        <div class="row">
            {{ $products->links() }}
        </div>
    </div>
@endsection

<style>
    .flex-row {
        display: flex;
    }

    .flex-item {
        flex: 1;
        margin: 10px;
        min-width: 200px;
    }
</style>
