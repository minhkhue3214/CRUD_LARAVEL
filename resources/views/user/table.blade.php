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
                    <th>ID người dùng</th>
                    <th>Tên người dùng</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->count() > 0)
                    @foreach ($users as $us)
                        <tr>
                            <td>{{ $us->id }}</td>
                            <td>{{ $us->name }}</td>
                            <td>{{ $us->role }}</td>
                            <td>{{ $us->email }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <div class="modal-footer">
                                        <form action="{{ route('packages.destroy', $us->id) }}" method="POST">
                                            <a type="button" href="{{ route('users.edit', $us->id) }}"
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
            {{ $users->links() }}
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



