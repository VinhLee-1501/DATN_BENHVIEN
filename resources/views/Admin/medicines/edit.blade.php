@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Cập nhật thuốc</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.medicines.update', $medicine->medicine_id) }}" method="post">
                        @method('patch')
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Mã thuốc</label>
                                    <input type="text" name="medicine_id" class="form-control" id=""
                                        value="{{ $medicine->medicine_id }}">
                                    @error('medicine_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Tên thuốc</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        value="{{ $medicine->name }}">
                                    @error('name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Nhóm</label>
                                    <select class="form-select" id="inputGroupSelect01" name="medicine_type_id">
                                        <option value="{{ $medicine->medicine_type_id }}" selected>
                                            {{ $medicine->medicine_types_name }}</option>
                                        @foreach ($medicineType as $item)
                                            <option value="{{ $item->medicine_type_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="inputGroupSelect01" name="status">
                                        @if ($medicine->status == 1)
                                            <option value="1" selected>Hoạt động</option>
                                            <option value="0">Hết
                                            <option>
                                        @else
                                            <option value="0" selected>Hết</option>
                                            <option value="1">Hoạt động
                                            <option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Hoạt tính</label>
                                    <textarea type="text" name="active_ingredient" class="form-control" id="">{{ $medicine->active_ingredient }}</textarea>
                                    @error('active_ingredient')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Đơn vị</label>
                                    <input type="text" name="unit_of_measurement" class="form-control"
                                        value="{{ $medicine->unit_of_measurement }}">
                                    @error('unit_of_measurement')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</a>
                    </form>
                </div>
            </div>
        @endsection
