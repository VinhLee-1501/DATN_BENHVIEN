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
                                <input type="text" id="inputName" class="form-control" placeholder="SDT" name="phone">
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
                                <h6 class="fw-semibold mb-0">Tên bệnh nhân</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">SDT</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Ngày khám</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Triệu chứng</h6>
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
                        @foreach ($book as $item)
                            <tr>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $item->name }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="fw-semibold mb-0">{{ $item->phone }}</span>
                                </td>
                                <td class="border-bottom-0">
                                    <span
                                        class="fw-semibold mb-0">{{ Carbon\Carbon::parse($item->day)->format('d/m/Y') }}</span>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="fw-semibold mb-0">{{ $item->symptoms }}</span>
                                </td>
                                <td class="border-bottom-0">
                                    <span class="fw-semibold mb-0">
                                        @if ($item->status == 2)
                                            <span class="badge bg-success">Đang khám</span>
                                    </span>
                                </td>
                                <td class="border-bottom-0 d-flex">
                                   
                                    <a href="{{ route('system.checkupHealth.record', $item->book_id) }}"
                                        class="btn btn-success text-sm ms-1">
                                        Khám
                                    </a>
                                </td>
                            @elseif (($item->status == 1))
                                <span class="badge bg-danger">Chưa khám</span>
                                </span>
                                </td>
                                <td class="border-bottom-0 d-flex">
                                 
                                    <a href="{{ route('system.checkupHealth.create', $item->book_id) }}"
                                        class="btn btn-success text-sm ms-1">
                                        Khám
                                    </a>
                                </td>
                        @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $book->links() !!}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#phoneInput, #nameInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
