<style>
    .img-container {
        width: 100%;
        max-width: 150px;
        aspect-ratio: 1 / 1;
    }

    .img-square {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-width: 50px;
        max-width: 150px;
    }

    .img-container-detail {
        width: 100%;
        max-width: 150px;
        aspect-ratio: 1 / 1;
    }

    .img-square-detail {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-width: 50px;
        max-width: 150px;
    }
</style>
<div class="d-flex align-items-center justify-content-between py-3">
    <div class="col-md-6 d-flex">
        <form action="" class="col-md-12 row">
            <div class="col-md-6">
                <input type="text" id="inputName" class="form-control" placeholder="Tên sản phẩm" name="name">
            </div>
        </form>
    </div>
    
</div>
<div class="card w-100">
    <div class="card-body p-4">
        <h5 class="card-title fw-semibold mb-4">Quản lý nhóm danh mục</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr class="text-center">
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">#</h6>
                        </th>
                      
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Tên nhóm</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Mô tả</h6>
                        </th>
                        <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Ngày thêm</h6>
                        </th>
                      
                    </tr>
                </thead>
                <tbody id="myTable">
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($categoryParent as $data)
                        <tr class="align-baseline">
                            <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0"> {{ $count++ }}</h6>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $data->name }}</p>
                            </td>
                             <td class="border-bottom-0">
                                <p class="mb-0 fw-semibold">{{ $data->description }}</p>
                            </td>
                            <td class="border-bottom-0 text-center">
                                <p class="mb-0 fw-semibold">
                                    {{ Carbon\Carbon::parse($data->create_at)->format('d/m/Y') }}</p>
                            </td>
                           
                            
                           
                        </tr>
                     
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>


