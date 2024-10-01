@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Thêm lịch làm bác sĩ
            </h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('system.schedules.store') }}" method="post">
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInput1" class="form-label">Ngày khám</label>
                                    <input type="date" name="day"
                                        class="form-control @error('day') is-invalid @enderror" id="">
                                    @error('day')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Bác sĩ</label>
                                    <select class="form-select @error('user_id') is-invalid @enderror"
                                        id="inputGroupSelect01" name="user_id">
                                        <option value="">Chọn Bác sĩ</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->user_id }}">{{ $item->lastname }}
                                                {{ $item->firstname }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputGroupSelect01" class="form-label">Phòng khám</label>
                                    <select class="form-select @error('sclinic_id') is-invalid @enderror"
                                        id="inputGroupSelect01" name="sclinic_id">
                                        <option value="">Chọn phòng khám</option>

                                        @foreach ($sclinic as $clinic)
                                            <option value="{{ $clinic->sclinic_id }}">{{ $clinic->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sclinic_id')
                                        <div class="text-danger">*{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Ghi chú</label>
                                    <textarea name="note"
                                              class="form-control @error('note') is-invalid @enderror"
                                              id=""> </textarea>
                                    @error('note')
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
