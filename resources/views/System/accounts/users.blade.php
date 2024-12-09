<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý người dùng</h5>
        <div class="table-responsive">
            {!! $users->links() !!}
            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr class="text-center">
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">ID</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Họ tên</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Số điện thoại</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Quyền</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Thao tác</h6>
                        </th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    @if($users->isEmpty())
                        <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
                    @else
                        @foreach ($users as $item)
                            <tr class="text-center">
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">{{ $item->user_id }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $item->lastname }} {{ $item->firstname }}</p>
                                </td>

                                <td class="border-bottom-0">
                                    <span class="fw-semibold mb-0">{{ $item->phone }}</span>
                                </td>

                                <td class="border-bottom-0">
                                    <span class="fw-semibold mb-0">
                                        <p class="badge bg-primary mb-0 fw-semibold">Bệnh nhân</p>
                                    </span>
                                </td>

                                <td class="border-bottom-0 d-flex justify-content-center align-items-center">
                                    <a href="{{ route('system.accounts.edit', $item->user_id) }}" class="btn btn-primary">
                                        <i class="ti ti-pencil"></i></a>
                                    <form action="{{ route('system.accounts.destroy', $item->user_id) }}"
                                        id="form-delete{{ $item->user_id }}" method="post">
                                        @method('delete')
                                        @csrf
                                    </form>
                                    <button type="submit" class="btn btn-danger btn-delete ms-1" data-id="{{ $item->user_id }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            {!! $users->links() !!}
        </div>
    </div>
</div>