@extends('layout')

@section('content')
    <div class="container">
        <h1>Testing oders</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            @if ($orders->count() > 0)
                @foreach ($orders as $order)
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $order->user_id }}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ $order->price }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    {{-- <button type="button" class="btn btn-danger m-0" data-toggle="modal"
                                        data-target="#myModal">Delete</button> --}}
                                    <div class="modal-footer">
                                        <form action="{{ route('home.destroy', $order->id) }}" method="POST">
                                            <a type="button" href="{{ route('home.show', $order->id) }}"
                                                class="btn btn-primary">Detail</a>
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
                    <td class="text-center" colspan="5">Không tìm thấy đơn hàng nào</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

@endsection
