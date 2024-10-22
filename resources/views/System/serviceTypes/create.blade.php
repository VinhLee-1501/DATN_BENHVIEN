@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm nhóm dịch vụ</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{route('system.serviceTypes.store')}}" method="post">
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Tên nhóm dịch vụ</label>
                                    <input type="text" name="name" class="form-control " id="">
                                    {{--  --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="statusSelect" name="status">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Dừng</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Hoạt động</option>
                                    </select>
                                    <input type="hidden" name="code" class="form-control " id=""
                                        value="{{ strtoupper(Str::random(10)) }}">

                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</a>
                    </form>
                </div>
            </div>
        @endsection
