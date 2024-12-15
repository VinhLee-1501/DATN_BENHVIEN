<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý lịch khám trực tuyến</h5>
        <div class="table-responsive">
            <div class="mb-3">
                {!! $online->links() !!}
            </div>
            <table class="table table-bordered text-nowrap mb-0 align-middle mb-3">
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
                                <h6 class="fw-semibold mb-0">Hình thức</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Thao tác</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @foreach ($online as $item)
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
                                    @if ($item->role == 1)
                                        <span class="badge bg-success">Online</span>
                                    @else
                                        <span class="badge bg-danger">Offline</span>
                                    @endif
                                </td>
                                <td class="border-bottom-0 d-flex">
                                    <a href="{{ route('system.Online.create', $item->book_id) }}"
                                        class="btn btn-success text-sm ms-1">
                                        Khám
                                    </a>
                                    @if($item->role == 1)
                                    <a href="{{ $item->url}}" target="_blank"
                                        class="btn btn-primary text-sm ms-1">
                                        Link
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>

            {!! $online->links() !!}
        </div>
    </div>
</div>