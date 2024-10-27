<table class="table text-nowrap mb-0 align-middle">
    <thead class="text-dark fs-4">
        <tr class="text-center">
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">ID</h6>
            </th>
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Số phòng</h6>
            </th>
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Chuyên khoa</h6>
            </th>
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Thao tác</h6>
            </th>
        </tr>
    </thead>
    @php
        $count = 1;
    @endphp
    <tbody id="myTable">
        @foreach ($specialties as $specialty)
            <tr class="text-center">
                <td class="border-bottom-0">{{ $count++ }}</td>
                <td class="border-bottom-0">{{ $specialty->name }}</td>
                <td class="border-bottom-0">
                    <a href="{{ route('system.detail', $specialty->specialty_id) }}" class="btn btn-primary">
                        <i class="ti ti-notes"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-primary "
                        onclick="openModalEdit('{{ $specialty->specialty_id }}')"><i class="ti ti-pencil"></i></a>
                    <form action="{{ route('system.delete', $specialty->specialty_id) }}"
                        id="form-delete{{ $specialty->specialty_id }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="submit" class="btn btn-danger btn-delete" data-id="{{ $specialty->specialty_id }}">
                        <i class="ti ti-trash"></i>
                    </button>

                </td>
            </tr>
        @endforeach
    </tbody>
</table>
