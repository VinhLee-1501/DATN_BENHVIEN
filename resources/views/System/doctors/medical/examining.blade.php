<div class="card w-100">
    <div class="card-body p-4">

        <div class="table-responsive">
            <div class="mb-3">
                {!! $medicalRecording->links() !!}
            </div>
            <table class="table table-bordered text-nowrap mb-0 align-middle mb-3">
                <thead class="text-dark fs-4">
                    <tr class="text-center">
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Bệnh nhân</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">SĐT Bệnh nhân</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Chuẩn đoán</h6>
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
                    @foreach ($medicalRecording as $item)
                        <tr class="text-center">
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
                                @if ($item->diaginsis == '')
                                    <p class="mb-0 fw-semibold">Chưa có chuẩn đoán</p>
                                @else
                                    <p class="mb-0 fw-semibold">{{ $item->diaginsis }}</p>
                                @endif
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
                                    class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></a>
                                <a href="{{ route('system.printMedical', $item->medical_id) }}"
                                    class="btn btn-danger btn-sm ms-2"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                        <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                        <path
                                            d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                    </svg></a>
                            </td>
                    @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $medicalRecording->links() !!}
        </div>
    </div>
</div>
