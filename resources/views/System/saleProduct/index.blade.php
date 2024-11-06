@extends('layouts.admin.master')
@section('Quản lý mã giảm giá sản phẩm')
@section('content')

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link  active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Hoạt động
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Không hoạt động
            </button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="d-flex align-items-center justify-content-between py-3">
            <div class="col-md-6 d-flex">
                <form action="" class="col-md-12 row">
                    <div class="col-md-6">
                        <input type="text" id="inputName" class="form-control" placeholder="Mã giảm giá" name="name">
                    </div>
                </form>
            </div>
            <div class="">
                <a href="javascript:void(0)" class="btn btn-success me-1" onclick='openAddModal()'>Thêm mã</a>
            </div>
        </div>
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            @include('System.saleProduct.saleProductActive')

        </div>

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

            @include('System.saleProduct.saleProductUnactive')

        </div>
    </div>


    {{-- Thêm  --}}
    <div class="modal fade" id="addSaleProductModalLabel" tabindex="-1" aria-labelledby="addSaleProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSaleProductModalLabel">Thêm Mã giảm giá sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSaleProductForm">
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="saleCode" class="form-label">Mã Giảm giá</label>
                                    <input type="text" name="saleCode" id="saleCode" class="form-control"
                                        value="">
                                    <div class="invalid-feedback" id="saleCode_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Giá giảm</label>
                                    <input type="text" class="form-control" name="discount" id="discount">
                                    <div class="invalid-feedback" id="discount_error"></div>
                                    <div class="d-flex mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="percentReduction"
                                                id="percentReduction">
                                            <label class="form-check-label" for="percentReduction">
                                                Giảm %
                                            </label>
                                        </div>
                                        <div class="form-check ms-5">
                                            <input class="form-check-input" type="checkbox" name="reduceMoney"
                                                id="reduceMoney" checked>
                                            <label class="form-check-label" for="reduceMoney">
                                                Giảm tiền
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="productId" class="form-label">Sản phẩm</label>
                                    <select class="form-select" name="productId" id="productId">

                                    </select>
                                    <div class="invalid-feedback" id="productId_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Thời gian bắt đầu</label>
                                    <input type="date" class="form-control" name="timeStart" id="timeStart">
                                    <div class="invalid-feedback" id="timeStart_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Thời gian kết thúc</label>
                                    <input type="date" class="form-control" name="timeEnd" id="timeEnd">
                                    <div class="invalid-feedback" id="timeEnd_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="statusActive"
                                        id="statusActive">
                                    <label class="form-check-label" for="statusActive">
                                        Hoạt động
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button class="btn btn-primary" id="addSaleProductBtn" type="submit">Thêm</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateSaleProductModalLabel" tabindex="-1" aria-labelledby="updateSaleProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateSaleProductModalLabel">Thêm Mã giảm giá sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateSaleProductForm">
                        @csrf
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="saleCode" class="form-label">Mã Giảm giá</label>
                                    <input type="text" name="saleCode" id="saleCodeEdit" class="form-control"
                                        value="">
                                        <input type="text" name="saleId" id="saleId" hidden>
                                    <div class="invalid-feedback" id="saleCodeEdit_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Giá giảm</label>
                                    <input type="text" class="form-control" name="discount" id="discountEdit">
                                    <div class="invalid-feedback" id="discountEdit_error"></div>
                                    <div class="d-flex mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="percentReductionEdit"
                                                id="percentReduction">
                                            <label class="form-check-label" for="percentReduction">
                                                Giảm %
                                            </label>
                                        </div>
                                        <div class="form-check ms-5">
                                            <input class="form-check-input" type="checkbox" name="reduceMoney"
                                                id="reduceMoneyEdit" checked>
                                            <label class="form-check-label" for="reduceMoney">
                                                Giảm tiền
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="productId" class="form-label">Sản phẩm</label>
                                    <select class="form-select productIdEdit" name="productId" id="productIdEdit">

                                    </select>
                                    <div class="invalid-feedback" id="productIdEdit_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Thời gian bắt đầu</label>
                                    <input type="date" class="form-control" name="timeStart" id="timeStartEdit">
                                    <div class="invalid-feedback" id="timeStartEdit_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Thời gian kết thúc</label>
                                    <input type="date" class="form-control" name="timeEnd" id="timeEndEdit">
                                    <div class="invalid-feedback" id="timeEndEdit_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="statusActive"
                                        id="statusActiveEdit">
                                    <label class="form-check-label" for="statusActive">
                                        Hoạt động
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button class="btn btn-primary" id="updateSaleProductBtn" type="submit">Cập nhật</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/assets/js/sale.js') }}"></script>

@endsection
