@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="col-md-12 d-flex justify-content-around align-items-center">
                <div class="col-md-12 d-flex justify-content-around align-items-center">
                    <div class="col-md-5">
                        <h5 class="card-title fw-semibold mb-4">Quản lý lịch khám</h5>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <form action="" class="col-md-12 row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Họ tên" name="name">
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="myInput" class="form-control" placeholder="SDT" name="phone">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary">Tìm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                    <tr>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">ID</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Họ tên</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">SDT</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Trạng thái</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @foreach( $book as $item)
                        <tr>
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">{{ $item->book_id }}</h6>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $item->name }}</p>
                            </td>
                            <td class="border-bottom-0">
                                <span class="fw-semibold mb-0">{{ '0'.$item->phone }}</span>
                            </td>
                            <td class="border-bottom-0">
                                <span class="fw-semibold mb-0">
                                    @if($item->status == 1)
                                        <span class="badge bg-success">Đã khám</span>
                                    @else
                                        <span class="badge bg-danger">Chưa khám</span>
                                    @endif
                                </span>
                            </td>
                            <td class="border-bottom-0 d-flex">
                                <a href="{{ route('system.editAppointmentSchedule',$item->book_id) }}"
                                   class="btn btn-primary me-1"><i class="ti ti-pencil"></i></a>
                                <form action="{{ route('system.deleteAppointmentSchedule', $item->book_id) }}"
                                      id="form-delete{{ $item->book_id }}" method="post">
                                    @method('delete')
                                    @csrf
                                </form>
                                <button type="submit" class="btn btn-danger btn-delete" data-id="{{$item->book_id }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
