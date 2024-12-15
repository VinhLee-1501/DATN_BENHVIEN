<div class="table-responsive">
    <div class="mt-3">
        {!! $book->links() !!}

    </div>
    <table class="table table-bordered text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4  ">
            <tr class="text-center">
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
            @if ($book->isEmpty())
            <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
            @else
            @php
            $count = 1;
            @endphp
            @foreach ($book as $item)
            <tr class="text-center">
                <td class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">{{ $count++ }}</h6>
                </td>
                <td class="border-bottom-0">
                    <p class="mb-0 fw-semibold">{{ $item->name }}</p>
                </td>
                <td class="border-bottom-0">
                    <span class="fw-semibold mb-0">{{ $item->phone }}</span>
                </td>
                <td class="border-bottom-0">
                    <span class="fw-semibold mb-0">
                        @if ($item->status == 0)
                        <span class="badge bg-danger">Đã đặt</span>
                        @elseif($item->status == 1)
                        <span class="badge bg-success">Xác nhận</span>
                        @elseif ($item->status == 2)
                        <span class="badge bg-success">Đã khám</span>
                        @else
                        <span class="badge bg-warning">Đã hủy</span>
                        @endif
                    </span>
                </td>
                <td class="border-bottom-0 d-flex justify-content-center align-items-center">

                    <a href="javascript:void(0)" class="btn btn-primary me-1"
                        onclick="openModal('{{ $item->book_id }}')"><i class="ti ti-pencil"></i></a>
                    <form action="{{ route('system.deleteAppointmentSchedule', $item->book_id) }}"
                        id="form-delete{{ $item->book_id }}" method="post">
                        @method('delete')
                        @csrf
                    </form>
                    <button type="submit" class="btn btn-danger btn-delete"
                        data-id="{{ $item->book_id }}">
                        <i class="ti ti-trash"></i>
                    </button>
                    <a class="btn btn-warning ms-1" data-bs-toggle="collapse"
                        href="#collapse{{ $item->book_id }}" role="button" aria-expanded="false"
                        aria-controls="collapse{{ $item->book_id }}">
                        Chi tiết
                    </a>
                </td>
            </tr>
            <tr id="show">
                <td colspan="10">
                    <div class="collapse" id="collapse{{ $item->book_id }}">
                        <div class="card card-body ">
                            <h6 class="fw-semibold mb-2 fs-5">Thông tin chi tiết:</h6>
                            <div class="col-md-12 row align-items-center">
                                <!-- Phần ảnh đại diện -->
                                <div class="col-md-4 text-center">
                                    <img src="{{ $item->avatar ? asset('storage/uploads/avatars/'. $item->avatar) : asset('backend/assets/images/profile/user-1.jpg') }}"
                                        alt="Ảnh đại diện bác sĩ" class="img-fluid rounded-circle"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <div class="col-md-4">
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Tên bác sĩ:</strong> {{ $item->lastname }}
                                            {{ $item->firstname }}
                                        </li>
                                        <li><strong>Chuyên khoa:</strong> {{ $item->specialtyName }}
                                        </li>
                                        <li><strong>Số điện thoại:</strong> {{ $item->phone }}</li>
                                        <li><strong>Phòng khám:</strong> {{ $item->sclinicName }}</li>
                                        <li><strong>Thời gian khám:</strong>
                                            {{ Carbon\Carbon::parse($item->day)->format('d/m/Y') }}
                                            @if (!empty($item->shiftName) && !empty($item->shiftNote))
                                            - {{ $item->shiftName }} ( {{ $item->shiftNote }} )
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4 text-start">
                                    <ul class="list-unstyled mb-0">
                                        <li><strong>Trạng thái:</strong>
                                            @if ($item->status == 0)
                                            <span class="badge bg-danger">Đã đặt</span>
                                            @elseif($item->status == 1)
                                            <span class="badge bg-success">Xác nhận</span>
                                            @elseif ($item->status == 2)
                                            <span class="badge bg-success">Đã khám</span>
                                            @else
                                            <span class="badge bg-warning">Đã hủy</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    {!! $book->links() !!}
</div>