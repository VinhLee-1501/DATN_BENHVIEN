@extends('layouts.admin.master')
@section('title', 'Quản lý chuyên khoa')
@section('content')

    <div class="card w-100">
        <div class="card-body p-4">
            <div class="col-md-12 d-flex justify-content-around align-items-center">
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <div class="col-md-5">
                        <h5 class="card-title fw-semibold mb-4">Quản lý chuyên khoa</h5>
                    </div>
                    <div class="col-md-7 d-flex justify-content-end mb-4">
                        <div class="w-100">
                            <input type="text" id="inputName" class="form-control"
                                   placeholder="Tìm kiếm bác sĩ" name="nameSpecialty">
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion" id="accordionExample">
                @foreach($doctorsSpecialty as $doctor)
                    <div class="accordion-item" id="myList">
                        <section>
                            <h2 class="accordion-header" id="heading{{ $doctor->user_id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $doctor->user_id }}" aria-expanded="true" aria-controls="collapse{{ $doctor->user_id }}">
                                    <strong>{{ $doctor->firstname }} {{ $doctor->lastname }}</strong>
                                </button>
                            </h2>
                            <div id="collapse{{ $doctor->user_id }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $doctor->user_id }}"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="col-md-12 d-flex justify-content-around align-items-center">
                                        <div class="col-md-4">
                                            <img
                                                src="{{ $doctor->avatar ? $doctor->avatar : asset('backend/assets/images/profile/user-1.jpg') }}"
                                                class="img-thumbnail w-50"/>
                                        </div>
                                        <div class="col-md-6 d-block">
                                            <div class="mb-3 ">
                                                <label for="exampleInputPassword1" class="form-label">
                                                    Chuyên khoa:
                                                </label>
                                                <span>{{ $doctor->name }}</span>
                                            </div>
                                            <div class="mb-3 ">
                                                <label for="exampleInputPassword1" class="form-label">
                                                    Số điện thoại:
                                                </label>
                                                <span>{{ $doctor->phone }}</span>
                                            </div>
                                            <div class="mb-3 ">
                                                <label for="exampleInputPassword1" class="form-label">
                                                    Email:
                                                </label>
                                                <span>{{ $doctor->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection
