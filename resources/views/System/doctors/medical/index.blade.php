@extends('layouts.admin.master')

@section('content')
    <div class="card w-100">
        <div class="card-body p-4">
            <div class="col-md-12 d-flex justify-content-around align-items-center">
                <div class="col-md-4">
                    <h5 class="card-title fw-semibold mb-4">Quản lý bệnh án</h5>
                </div>
                <div class="col-md-4">
                    <input type="text" id="inputName" class="form-control" placeholder="Tìm bệnh nhân">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Chuẩn đoán</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Bệnh nhân</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">SĐT Bệnh nhân</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Ngày khám</h6>
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
                        @foreach ($medicalRecord as $item)
                            <tr>
                                <td class="border-bottom-0">
                                   
                                        @if($item->diaginsis == '')
                                        <p class="mb-0 fw-semibold">Chưa có chuẩn đoán</p>
                                        @else
                                        <p class="mb-0 fw-semibold">{{ $item->diaginsis }}</p>
                                        @endif
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">
                                        {{ $item->patientForeignKey->last_name . ' ' . $item->patientForeignKey->first_name }}
                                    </p>
                                    <p class="mb-0 fw-semibold" hidden>{{ $item->patientForeignKey->phone }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">{{ $item->patientForeignKey->phone }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-semibold">
                                        {{ Carbon\Carbon::parse($item->date)->format('H:m  d/m/Y') }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    @if ($item->status == 2)
                                        <span class="badge bg-warning">Đang khám</span>
                                </td>
                                <td class="border-bottom-0 d-flex">
                                    <a href="{{ route('system.recordDoctors.record', $item->medical_id) }}"
                                        class="btn btn-success btn-sm">
                                        Khám
                                    </a>
                                </td>
                            @elseif($item->status == 3)
                                <span class="badge bg-success">Đã khám</span>
                                </td>
                                <td class="border-bottom-0 d-flex">
                                    <a href="{{ route('system.recordDoctors.detail', $item->medical_id) }}"
                                        class="btn btn-primary btn-sm">Xem</a>
                                </td>
                        @endif


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#phoneInput, #nameInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
