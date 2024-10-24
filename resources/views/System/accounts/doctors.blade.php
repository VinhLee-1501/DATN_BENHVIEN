<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý tài khoản bác sĩ</h5>
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
                        <h6 class="fw-semibold mb-0">Chuyên Khoa</h6>
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

                @foreach($doctors as $item)
                    <tr>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">{{ $item->user_id  }}</h6>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">{{ $item->lastname }} {{ $item->firstname }}</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-semibold">{{ $item->specialty_name }}</p>
                        </td>
                        <td class="border-bottom-0">
                            <p class="badge bg-success mb-0 fw-semibold">Bác sĩ</p>
                        </td>
                        <td class="border-bottom-0 d-flex">
                            <a href="{{ route('system.accounts.edit', $item->user_id) }}" class="btn btn-primary"><i
                                    class="ti ti-notes"></i></a>
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


                </tbody>


            </table>
        </div>
    </div>
</div>
