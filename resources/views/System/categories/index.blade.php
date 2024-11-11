@extends('layouts.admin.master')
@section('Quản lý sản phẩm')
@section('content')
    <style>
        #addProductForm {
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            /* Căn các nút sang bên phải */
            width: 100%;
        }
    </style>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link  active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Danh mục
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
                role="tab" aria-controls="nav-profile" aria-selected="false">Danh mục nhóm
            </button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            @include('System.categories.category')

        </div>


        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

            @include('System.categories.parent_category')

        </div>
    </div>


  


@endsection
