@extends('layout')

@section('content')
    <div class="container">

        <div class="flex-row">
            <h2>Quản lý gói sản phẩm</h2>
        </div>

        <form action="" class="col-9">
            <div class="input-group">
                <input type="search" name="search" style="width: 500px" id="" class="form-control"
                    placeholder="Tìm kiếm bằng tên gói sản phẩm">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
        <a type="button" class="btn btn-success" href="{{ url('packages/create') }}">ADD PACKAGE</a>

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
                    <th>ID gói sản phẩm</th>
                    <th>Tên gói sản phẩm</th>
                    <th>Giá gói sản phẩm</th>
                    <th>Mô tả gói sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($packages->count() > 0)
                    @foreach ($packages as $pr)
                        <tr>
                            <td>{{ $pr->id }}</td>
                            <td>{{ $pr->name }}</td>
                            <td>testing</td>
                            <td>{{ $pr->description }}</td>
                            <td>
                                <img src="{{$pr->image}}" width="60" height="60" alt="">
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    {{-- <button type="button" class="btn btn-danger m-0" data-toggle="modal"
                                        data-target="#myModal">Delete</button> --}}
                                    <div class="modal-footer">
                                        <form action="{{ route('packages.destroy', $pr->id) }}" method="POST">
                                            <a type="button" href="{{ route('packages.show', $pr->id) }}"
                                                class="btn btn-primary">Detail</a>
                                            <a type="button" href="{{ route('packages.edit', $pr->id) }}"
                                                class="btn btn-success">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger m-0">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">Không tìm thấy gói sản phẩm nào</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="row">
            {{ $packages->links() }}
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
