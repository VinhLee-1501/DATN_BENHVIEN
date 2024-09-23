@extends('layouts.admin.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4 text-center">Bs. Nguyen Van B</h5>
            <div class="card">
                <div class="col-md-12 row">
                    <div class="col-md-3">
                        <div class="header-info">
                            <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}"
                                 class="img-thumbnail rounded-circle w-75" alt="...">
                            <span class="text-center fs-6 fw-bold">Nguyen Van A</span>
                        </div>
                        <hr class="w-50 m-md-4">
                        <div class="footer-info mt-3">
                            <h6 class="fw-bold">Thông tin</h6>
                            <div class="info">
                                <div class="phone">
                                    <span>
                                        <i class="ti ti-phone"></i>
                                    </span> +84 877894434
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <h6 class="fw-semibold mb-4">I. Hành chính</h6>
                                <div class="table-responsive ms-3">
                                    <div class="title fs-4">
                                        <span class="fw-bold">Họ tên: </span>
                                        Nguyen Van B
                                    </div>
                                    <div class="name fs-4">
                                        <span class="fw-bold">Email: </span>
                                        nguyenb@hmail.com
                                    </div>
                                    <div class="birthday fs-4">
                                        <span class="fw-bold">Ngày sinh: </span>
                                        04/01/1970
                                    </div>
                                    <div class="address fs-4">
                                        <span class="fw-bold">Giới tính: </span>
                                        Nam
                                    </div>
                                    <div class="address fs-4">
                                        <span class="fw-bold">Địa chỉ: </span>
                                        Việt Nam
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-4 mt-3">II. Thông tin nghề nghiệp</h6>
                                <div class="infomation">
                                    <div class="introdu">
                                        <p class="fw-bold">BS. Nguyen Van B
                                        <p>là chuyên gia hàng đầu ngành tai, mũi, họng</p>
                                        </p>
                                        <p class="fw-bold">Giới thiêu</p>

                                        <p>PGS Nguyen Van B có gần 40 năm kinh nghiệm trong lĩnh vực nội soi và phẫu
                                            thuật tai, mũi, họng. “Bàn tay vàng” của ông đã giúp hàng nghìn người cải
                                            thiện
                                            sức khỏe
                                            và chất lượng sống. Với những cống hiến to lớn cho nền y học nước nhà,
                                            PGS Nguyen Van B nhận được nhiều Bằng khen của Thủ tướng Chính phủ,
                                            Bộ trưởng Bộ Y tế, đạt danh hiệu Chiến sĩ thi đua cấp Bộ, cấp viện nhiều năm
                                            liên tục, Bằng khen tuổi trẻ sáng tạo thủ đô, Kỷ niệm
                                            chương “Vì sự nghiệp Khoa học và Công nghệ”…</p>

                                        <p>Lịch sử hành nghề</p>
                                        <p>
                                            Sau khi tốt nghiệp bác sĩ đa khoa tại Học viện Quân Y năm 1985, bác sĩ B
                                            tiếp
                                            tục tham gia các khóa đào tạo sau đại học tại Học viện Quân Y (1989),
                                            nghiên cứu sinh năm 1996 và đào tạo chuyên sâu về Phẫu thuật nội soi tại
                                            Bệnh
                                            viện Việt Đức (1992), tại Thái Lan (1996), tại Hàn Quốc, Pháp (2004), tại
                                            Singapore (2007); Đào tạo phẫu thuật lạnh tại Ucraina (2007) và Đào tạo ghép
                                            gan
                                            – tụy tại Hàn Quốc (2017)… PGS B thường xuyên tham dự các hội nghị hội thảo,
                                            tập huấn ngắn hạn trong nước và quốc tế về phẫu thuật ung thư đường tiêu
                                            hóa,
                                            phẫu thuật nội soi nâng cao.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
