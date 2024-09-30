@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm thuốc</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('system.medicines.store') }}" method="post">
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Mã thuốc</label>
                                    <input type="text" name="medicine_id" class="form-control" id=""
                                        value="{{ strtoupper(Str::random(10)) }}">
                                    @error('medicine_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Tên thuốc</label>
                                    <input type="text" name="name" class="form-control" id="">
                                    @error('name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Nhóm</label>
                                    <select class="form-select" id="inputGroupSelect01" name="medicine_type_id">
                                        @foreach ($medicineType as $item)
                                            <option value="{{ $item->medicine_type_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Hoạt tính</label>
                                    <textarea type="text" name="active_ingredient" class="form-control" id=""></textarea>
                                    @error('active_ingredient')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Đơn vị</label>
                                    <input type="text" name="unit_of_measurement" class="form-control" id="">
                                    @error('unit_of_measurement')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Thêm</button>
                    </form>
                </div>
            </div>
        @endsection
