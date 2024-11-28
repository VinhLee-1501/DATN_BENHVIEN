@extends('layouts.admin.master')
@section('title', 'Quản lý chuyên khoa')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Danh sách bác sĩ khoa {{ $name->first()->name}}</h5>
        <form action="{{ route('system.detail_specialty', $name->first()->specialty_id) }}" method="GET" class="mb-3 row g-2 justify-content-between align-items-center">

            <!-- Cột chứa các trường tìm kiếm -->
            <div class="col-12 col-lg-10">
                <div class="row g-2">
                    <div class="col-lg-4 col-12">
                        <input type="text" name="lastname" class="form-control" placeholder="Họ" value="{{ request('lastname') }}">
                    </div>
                    <div class="col-lg-4 col-12">
                        <input type="text" name="firstname" class="form-control" placeholder="Tên" value="{{ request('firstname') }}">
                    </div>
                    <div class="col-lg-4 col-12">
                        <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="{{ request('phone') }}">
                    </div>
                </div>
            </div>

            <!-- Cột chứa nút tìm kiếm -->
            <div class="col-12 col-lg-2">
                <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
            </div>

        </form>




        <div class="accordion" id="accordionExample">
            @if($doctorsSpecialty->isEmpty())
            <div id="noResults" class="alert alert-warning">Không tìm thấy dữ liệu.</div>
            @else
            @foreach ($doctorsSpecialty as $doctor)
            <div class="accordion-item" id="myList">
                <section>
                    <h2 class="accordion-header" id="heading{{ $doctor->user_id }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $doctor->user_id }}" aria-expanded="true"
                            aria-controls="collapse{{ $doctor->user_id }}">
                            <strong>{{ $doctor->lastname }} {{ $doctor->firstname }}</strong>
                        </button>
                    </h2>
                    <div id="collapse{{ $doctor->user_id }}" class="accordion-collapse collapse show"
                        aria-labelledby="heading{{ $doctor->user_id }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                                    @if (empty($doctor->avatar))
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                        alt="Ảnh bác sĩ" class="img-thumbnail"
                                        style="width: 150px; height: auto;">
                                    @else
                                    @if ($doctor->google_id || $doctor->zalo_id || $doctor->facebook_id)
                                    <img src="{{ $doctor->avatar }}" alt="Ảnh bác sĩ" class="img-thumbnail"
                                        style="width: 150px; height: auto;">
                                    @else
                                    @if ($doctor->avatar === 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png')
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png"
                                        alt="Ảnh bác sĩ" class="img-thumbnail"
                                        style="width: 150px; height: auto;">
                                    @else
                                    <img src="{{ asset('storage/uploads/avatars/' . $doctor->avatar) }}"
                                        alt="Ảnh bác sĩ" class="img-thumbnail"
                                        style="width: 150px; height: auto;">
                                    @endif
                                    @endif
                                    @endif
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="specialty" class="form-label">
                                            Chuyên khoa:
                                        </label>
                                        <span>{{ $doctor->name }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">
                                            Số điện thoại:
                                        </label>
                                        <span>{{ $doctor->phone }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
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
            @endif
        </div>

    </div>
</div>

@endsection