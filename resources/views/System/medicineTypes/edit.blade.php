@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm nhóm thuốc</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{route('system.medicineTypes.update', $medicine->medicine_type_id)}}" method="post">
                        @method('patch')
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Mã nhóm thuốc</label>
                                    <input type="text" name="code" class="form-control" id=""
                                        value="{{ $medicine->medicine_type_id }}">
                                    @error('code')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Tên nhóm thuốc</label>
                                    <input type="text" name="name" class="form-control" id="" value="{{ $medicine->name }}">
                                    @error('name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Trạng thái</label>
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
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</a>
                    </form>
                </div>
            </div>
        @endsection
