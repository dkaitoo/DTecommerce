@extends('seller.layouts.app')
@push('javascript')
    {{--    <script src="https://cdn.tiny.cloud/1/4r7wne3vt2vooka291s9beziyj4dij9bxso4ftvmg81k1t6t/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>--}}
    <script src="{{config('app.key_tiny')}}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
@endpush
@section('content')
{{--</div>--}}
<div class="main-panel" id="main-panel">
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary text-uppercase modal-header" style="padding: 0px;"> <b>Thêm sản phẩm</b></h4>
                <!-- Tab panes -->
                <div class="content">
                    <div class="card">
                        <div class="card-body">
                            
                            <form novalidate action="{{route('productSeller.store')}}" enctype="multipart/form-data"  method="POST">
                                @csrf
                                {{--Chia ra làm 2 part--}}
                                {{--1. Thông tin chung--}}
                                @include('flash-message')
                                <div class="row justify-content-md-center">
                                    <div class="col-md col-sm col-xs">
                                        <div class="form-group">
                                            <label><b>Loại sản phẩm</b></label>
                                            <select name="category_id" class="form-control">
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{$category->id == old('category_id')? 'selected':''}}>
                                                        {{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><b>Thương hiệu</b></label>
                                            <select name="brand" class="form-control">
                                                @foreach($brands as $brand)
                                                    <option value="{{$brand->name}}" {{$brand->name == old('brand')? 'selected':''}}>
                                                        {{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><b>Tên sản phẩm</b></label>
                                            <input name="name" type="text"  placeholder="Tên sản phẩm" class="form-control" value="{{old('name')}}" required>
                                        </div>
                                        <div class="form-group" style="padding-top: 10px;">
                                            <label><b>Tiêu đề hiển thị</b></label>
                                            <h6>(Sẽ được cập nhật sau khi tạo sản phẩm)</h6>
                                        </div>

                                    </div>
                                    <div style="border-left: 1px solid rgb(114, 114, 114); height: 310px;">
                                    </div>
                                    <div class="col-md col-sm col-xs">

                                        <div class="form-group">
                                            <label class="form-label"><b>Giá bán ban đầu</b></label>
                                            <input name="original_price" type="number" class="form-control" value="{{old('original_price')}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"><b>Giá bán khi giảm</b></label>
                                            <input name="selling_price" type="number" class="form-control" value="{{old('selling_price')}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_title">Số lượng</label>
                                            <input type="text" class="form-control" id="meta_title" name="qty" placeholder="Số lượng" value="{{old('qty')}}" maxlength="9" >
                                        </div>
                                        <div class="form-group">
                                            
                                            @if(old('status'))
                                                <input type="checkbox" name="status" {{old('status') ? 'checked':''}}>
                                            @else
                                                <input type="checkbox" name="status" checked>
                                            @endif
                                            <label for="status">Trạng thái</label>
                                            <br>
                                            
                                            <input type="checkbox" name="trending" {{old('trending') ? 'checked':''}}>
                                            <label for="trending">Xu hướng</label>
                                        </div>
{{--                                        <div class="form-group">--}}
{{--                                            <label for="meta_keywords">Từ khóa tìm kiếm (vd: áo đẹp, giày xanh,...)</label>--}}
{{--                                            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Từ khóa tìm kiếm" value="{{old('meta_keywords')}}" />--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                                {{--Cần xử lý được các thuộc tính name khác nhau (dạng radio) r lưu về cùng 1 mảng trc khi đưa vào csdl--}}
                                <div class="form-group">
                                    {{--Thêm cái button show hide here--}}
                                    <label><b>Màu sắc <span style="font-style: italic; color: red;">(* Nếu có)</span></b></label>
                                    <div class="row">
                                        @forelse($colors as $colorItem)
                                            <div class="col-md-1 text-center">
                                                <div class="p-2 border mb-3">
                                                    <label>
                                                        <input type="checkbox" name="attribute[]" value="{{ $colorItem->id }}"/>
                                                        <i class="fa fa-paint-brush" style="font-size:24px;color:{{$colorItem->value}};"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <p>Không có màu nào.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{--Thêm cái button show hide here--}}
                                    <label><b>Kích cỡ <span style="font-style: italic; color: red;">(* Nếu có)</span> </b></label>
                                    <div class="row">
                                        @forelse($sizes as $sizeItem)
                                            <div class="col-md-1">
                                                <div class="p-2 border mb-3">
                                                    <label>
                                                        <input type="checkbox" name="attribute[]" value="{{ $sizeItem->id }}"
                                                        />
                                                        {{$sizeItem->value}}
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <p>Không có kích cỡ nào.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="row justify-content-md-center">
                                    <div class="col-md col-sm col-xs">
                                        <div class="form-group">
                                            <label><b>Kích thước <span style="font-style: italic; color: red;">(* Nếu có)</span> </b><br>
                                                <small>Kích thước sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                            </label>
        
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <select name="dimension" class="input-select">
                                                        <option value="">
                                                            Chọn Kích thước
                                                        </option>
                                                        @forelse($dimensions as $dimensionItem)
                                                            <option value="{{$dimensionItem->id}}" {{$dimensionItem->id == old('dimension') ? 'selected' : ''}}>
                                                                {!! $dimensionItem->value !!}
                                                            </option>
                                                        @empty
                                                            <option value="">
                                                                Không có giá trị nào
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="form-group">
                                            <label><b>Bộ nhớ <span style="font-style: italic; color: red;">(* Nếu có)</span> </b>
                                                <br>
                                                <small><b>Bộ nhớ</b> sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                            </label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <select name="memory" class="input-select">
                                                        <option value="">
                                                            Chọn Bộ nhớ
                                                        </option>
                                                        @forelse($memories as $memoryItem)
                                                            <option value="{{$memoryItem->id}}" {{$memoryItem->id == old('memory') ? 'selected' : ''}}>
                                                                {!! $memoryItem->value !!}
                                                            </option>
                                                        @empty
                                                            <option value="">
                                                                Không có giá trị nào
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div style="border-left: 1px solid rgb(114, 114, 114); height: 220px;">
                                    </div>
                                    <div class="col-md col-sm col-xs">
                                        <div class="form-group">
                                            <label><b>Thể tích/trọng lượng/diện tích <span style="font-style: italic; color: red;">(* Nếu có)</span></b>
                                                <br>
                                                <small><b>Thể tích/trọng lượng/diện tích</b> sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                            </label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <select name="volume" class="input-select">
                                                        <option value="">
                                                            Chọn Thể tích/trọng lượng/diện tích
                                                        </option>
                                                        @forelse($volumes as $volumeItem)
                                                            <option value="{{$volumeItem->id}}" {{$volumeItem->id == old('volume') ? 'selected' : ''}}>
                                                                {!! $volumeItem->value !!}
                                                            </option>
                                                        @empty
                                                            <option value="">
                                                                Không có giá trị nào
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                </div>
        
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><b>Thuộc tính khác <span style="font-style: italic; color: red;">(* Nếu có)</span></b></label><br>
                                            <small>Mỗi sản phẩm chỉ được nhập một "Thuộc tính khác", thuộc tính này sẽ được hiển thị trực tiếp trong "Tiêu đề hiển thị".</small><br>
                                            <input name="other_attribute" type="text" class="form-control" value="" placeholder="Thuộc tính khác"
                                                   value="{{old('other_attribute')}}">
                                        </div>
                                        
                                    </div>
                                </div>
                                {{-- <div class="form-group">
                                    <label><b>Kích thước <span style="font-style: italic; color: red;">(* Nếu có)</span> </b><br>
                                        <small>Kích thước sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                    </label>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="dimension" class="input-select">
                                                <option value="">
                                                    Chọn Kích thước
                                                </option>
                                                @forelse($dimensions as $dimensionItem)
                                                    <option value="{{$dimensionItem->id}}" {{$dimensionItem->id == old('dimension') ? 'selected' : ''}}>
                                                        {!! $dimensionItem->value !!}
                                                    </option>
                                                @empty
                                                    <option value="">
                                                        Không có giá trị nào
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><b>Bộ nhớ <span style="font-style: italic; color: red;">(* Nếu có)</span> </b>
                                        <br>
                                        <small><b>Bộ nhớ</b> sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="memory" class="input-select">
                                                <option value="">
                                                    Chọn Bộ nhớ
                                                </option>
                                                @forelse($memories as $memoryItem)
                                                    <option value="{{$memoryItem->id}}" {{$memoryItem->id == old('memory') ? 'selected' : ''}}>
                                                        {!! $memoryItem->value !!}
                                                    </option>
                                                @empty
                                                    <option value="">
                                                        Không có giá trị nào
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><b>Thể tích/trọng lượng/diện tích <span style="font-style: italic; color: red;">(* Nếu có)</span></b>
                                        <br>
                                        <small><b>Thể tích/trọng lượng/diện tích</b> sẽ tự động được thêm vào tên để dễ phân biệt</small>
                                    </label>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="volume" class="input-select">
                                                <option value="">
                                                    Chọn Thể tích/trọng lượng/diện tích
                                                </option>
                                                @forelse($volumes as $volumeItem)
                                                    <option value="{{$volumeItem->id}}" {{$volumeItem->id == old('volume') ? 'selected' : ''}}>
                                                        {!! $volumeItem->value !!}
                                                    </option>
                                                @empty
                                                    <option value="">
                                                        Không có giá trị nào
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><b>Thuộc tính khác <span style="font-style: italic; color: red;">(* Nếu có)</span></b></label><br>
                                    <small>Mỗi sản phẩm chỉ được nhập một "Thuộc tính khác", thuộc tính này sẽ được hiển thị trực tiếp trong "Tiêu đề hiển thị".</small><br>
                                    <input name="other_attribute" type="text" class="form-control" value="" placeholder="Thuộc tính khác"
                                           value="{{old('other_attribute')}}">
                                </div> --}}


                                {{--2. Mô tả chi tiết--}}
                                <div class="mb-3">
                                    <label class="form-label"><b>Hình ảnh</b></label>
                                    <input name="image[]" id="file-upload-button" type="file" accept="image/*" class="form-control"
                                           required multiple>
                                </div>

                                <div class="form-group">
                                    <label><b>Mô tả chi tiết sản phẩm</b></label>
                                    <textarea class="form-control" name="description">{{old('description')}}</textarea>
                                </div>

                                <div class="modal-footer justify-content-md-start">
                                    <input type="submit" class="btn btn-success" value="Lưu lại">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".tab").removeClass("active");
        // $(".tab").addClass("active"); // instead of this do the below
        $("#tab-4").addClass("active");
    });
</script>
@endsection
