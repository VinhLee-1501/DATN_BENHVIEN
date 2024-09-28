@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm nhóm thuốc</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.medicineTypes.store') }}" method="post">
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Mã nhóm thuốc</label>
                                    <input type="text" name="code" class="form-control" id=""
                                        value="{{ strtoupper(Str::random(10)) }}">
                                    @error('code')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Tên nhóm thuốc</label>
                                    <input type="text" name="name" class="form-control" id="">
                                    @error('name')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</a>
                    </form>
                </div>
            </div>
        @endsection
