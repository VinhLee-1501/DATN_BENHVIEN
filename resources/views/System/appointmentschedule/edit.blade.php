@php use App\Helper\SelectDoctor; @endphp
@extends('layouts.admin.master')
@section ('title', 'Danh sách lịch khám' )
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Sửa lịch khám</h5>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('system.updateAppointmentSchedule', $book->book_id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Họ tên</label>
                                    <input type="text" name="name" class="form-control" value="{{ $book->name }}"
                                           readonly>
                                </div>
                                @error('name')
                                <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Ngày đặt</label>
                                    <input type="date" class="form-control @error('day') is-invalid @enderror"
                                           name="day"
                                    >
                                    @error('day')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $book->email }}"
                                           readonly>
                                </div>
                                @error('email')
                                <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $book->phone }}"
                                           readonly>
                                </div>
                                @error('phone')
                                <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Bác sĩ thăm khám</label>
                                    <select name="user_id" class="form-control js-example-basic-single">
                                        {!! SelectDoctor::selectDoctorName($book->book_id) !!}
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Triệu chứng</label>
                                <textarea class="form-control" name="symptoms" id="" cols="10" rows="5" readonly>{{ $book->symptoms }}</textarea>
                                @error('symptoms')
                                <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                    </form>
                </div>
            </div>
@endsection

