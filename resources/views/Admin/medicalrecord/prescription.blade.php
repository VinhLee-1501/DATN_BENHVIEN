@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 text-center">Đơn thuốc</h5>
            <div class="card">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <form>
                                    <div class="table-responsive ms-3">
                                        <div class="col-md-12 row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">
                                                        Họ và tên:
                                                    </label>
                                                    <span class="text-bold">{{ $treatment[0]->last_name }} {{ $treatment[0]->first_name }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="exampleInputPassword1" class="form-label">
                                                        Tuổi:
                                                    </label>
                                                    <span class="text-bold">
                                                       @php
                                                           $birthday = \Carbon\Carbon::parse($treatment[0]->birthday)->year;
                                                            $today = \Carbon\Carbon::today()->year;
                                                            $age = $today - $birthday;
                                                            echo $age;
                                                       @endphp
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="exampleInputPassword1" class="form-label">
                                                        Giới tính:
                                                    </label>
                                                    <span class="text-bold">
                                                        @if($treatment[0]->gender == 1)
                                                            Nam
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <label for="exampleInputPassword1" class="form-label">
                                                            Chuẩn đoán:
                                                        </label>
                                                        <span>{{ $treatment[0]->diaginsis }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="fw-semibold mb-4 mt-3">Thuốc đìều trị</h6>
                                    <div class="col-md-12">
                                        <div class="">
                                            <table class="table text-nowrap mb-0 align-middle border-success ">
                                                <thead class="text-dark fs-4">
                                                <tr>
                                                    <th class="border-bottom-0 col-1">STT</th>
                                                    <th class="border-bottom-0 text-center">Thuốc điều trị</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ( $treatment as $item )
                                                    <tr>
                                                        <td>{{ $loop->iteration  }}</td>
                                                        <td>
                                                            <div class="col-md-12 row">
                                                                <div class="col-md-6">
                                                                    <p class="fs-4 mb-0 fw-bolder">{{ $item->name }}</p>
                                                                    <p class="fs-3 mb-0">{{ $item->usage }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    {{ $item->quantity }} Viên
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
