@extends('admin.layouts.app')

@push('styles')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link href="{{ asset('css/showProduct.css') }}" rel="stylesheet" />
@endpush

@push('javascript')
        <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
@endpush

@section('content')
<div class="main-panel" id="main-panel">
  <div class="panel-header panel-header-sm">
  </div>

    <div class="content">
        <div class="card">
        <a href="{{route('product.index')}}" class="text-success "><i class="fa fa-solid fa-2x fa-angle-left mb-3"></i></a>

        <div class="container-fluid ">
            <div class="wrapper row">
                <div class="preview col-md-6" style="padding-left: 5rem;">

                        <div class="preview-pic tab-content" >
                            @if($product->productImages)
                                @forelse($product->productImages as $image)
                                    @if(($loop->index) == 0)
                                        <div class="tab-pane active" id="pic-1"><img src="{{url($image->image)}}" alt="Img" height="100%"/></div>
                                    @else
                                        <div class="tab-pane" id="pic-{{ ($loop->index)+1 }}"><img src="{{url($image->image)}}" alt="Img" height="100%"/></div>
                                    @endif
                                @empty
                                    <div class="tab-pane active" id="pic-1"><img src="{{ url('/img/giftbox.png') }}" alt="Img" height="100%"/></div>
                                @endforelse
                            @else
                                <div class="tab-pane active" id="pic-1"><img src="{{ url('/img/giftbox.png') }}" alt="Img" height="100%"/></div>
                            @endif
                        </div>
                        <ul class="preview-thumbnail nav nav-tabs">
                            @if($product->productImages)
                                @forelse($product->productImages as $image)
                                    @if(($loop->index) == 0)
                                        <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="{{url($image->image)}}" alt="Img" /></a></li>
                                    @else
                                        <li><a data-target="#pic-{{ ($loop->index)+1 }}" data-toggle="tab"><img src="{{url($image->image)}}" alt="Img"/></a></li>
                                    @endif
                                @empty
                                    <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="{{ url('/img/giftbox.png') }}" alt="Img" /></a></li>
                                @endforelse
                            @else
                                <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="{{ url('/img/giftbox.png') }}" alt="Img" /></a></li>
                            @endif
                        </ul>

                </div>
                <div class="details col-md-6">
                    <h3 class="product-title">{!! $product->tittle !!}</h3>
{{--                    <div class="rating">--}}
{{--                        <div class="stars">--}}
{{--                            <span class="fa fa-star checked"></span>--}}
{{--                            <span class="fa fa-star checked"></span>--}}
{{--                            <span class="fa fa-star checked"></span>--}}
{{--                            <span class="fa fa-star"></span>--}}
{{--                            <span class="fa fa-star"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <p class="product-description">Suspendisse quos? Tempus cras iure temporibus? Eu laudantium cubilia sem sem! Repudiandae et! Massa senectus enim minim sociosqu delectus posuere.</p>--}}
                    <a class="text-info"><b>{{$product->category->name}}</b></a>
                    <h4 style="margin-top: 20px;">
                        Giá bán: <strong style="color: rgb(234, 59, 118); font-size: 22px;">{{number_format($product->selling_price, 0, '', '.'). 'đ'}}</strong>&nbsp;
                        <del style="color: #6c757d;">{{number_format($product->original_price, 0, '', '.'). 'đ'}}</del>
                    </h4>
{{--                    <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>--}}
{{--                    <h5 class="sizes">sizes:--}}
{{--                        <span class="size" data-toggle="tooltip" title="small">s</span>--}}
{{--                        <span class="size" data-toggle="tooltip" title="medium">m</span>--}}
{{--                        <span class="size" data-toggle="tooltip" title="large">l</span>--}}
{{--                        <span class="size" data-toggle="tooltip" title="xtra large">xl</span>--}}
{{--                    </h5>--}}
                    <h4>Số lượng sản phẩm: <b>{{$product->qty}}</b></h4>
                    @if(in_array('color',$attributes_name))
                        <h4 id="color">Màu sắc:
                            @forelse($colors as $colorItem)
                                @if($attributes)
                                    <span style="display: {{in_array($colorItem->id,$attributes) ? '' : 'none'}};">
                                        <i class="fa fa-paint-brush" style="font-size:24px;color:{{$colorItem->value}};"></i>
                                    </span>
                                @endif
                            @empty
                            @endforelse
                        </h4>
                    @endif

                    @if(in_array('size',$attributes_name))
                    <h4 id="size">Kích cỡ:
                        @forelse($sizes as $sizeItem)
                            @if($attributes)
                                <strong style="display: {{in_array($sizeItem->id,$attributes) ? '' : 'none'}};">
                                    {{$sizeItem->value}}
                                </strong>
                            @endif
                        @empty
                        @endforelse
                    </h4>
                    @endif

                    @if(in_array('dimension',$attributes_name))
                    <h4 id="dimension">Kích thước:
                        @forelse($dimensions as $dimensionItem)
                            @if($attributes)
                                <strong style="display: {{in_array($dimensionItem->id,$attributes) ? '' : 'none'}};">
                                    {{$dimensionItem->value}}
                                </strong>
                            @endif
                        @empty
                        @endforelse
                    </h4>
                    @endif

                    @if(in_array('memory',$attributes_name))
                    <h4 id="memory">Bộ nhớ:
                        @forelse($memories as $memoryItem)
                            @if($attributes)
                                <strong style="display: {{in_array($memoryItem->id,$attributes) ? '' : 'none'}};">
                                    {{$memoryItem->value}}
                                </strong>
                            @endif
                        @empty
                        @endforelse
                    </h4>
                    @endif

                    @if(in_array('volume',$attributes_name))
                    <h4 id="volume">Thể tích/trọng lượng/diện tích :
                        @forelse($volumes as $volumeItem)
                            @if($attributes)
                                <strong style="display: {{in_array($volumeItem->id,$attributes) ? '' : 'none'}};">
                                    {!! $volumeItem->value !!}
                                </strong>
                            @endif
                        @empty
                        @endforelse
                    </h4>
                    @endif

                    <div>
                        <a href="{{route('product.index')}}/{{$product->id}}/edit" class="add-to-cart btn btn-primary" type="button">Cập nhật</a>
                        {{--                        <a class="like btn btn-danger" type="button"><span class="fa fa-trash"></span></a>--}}
                    </div>
                </div>
                <div class="d-block" style="margin-top: 40px; padding-left: 5rem;">
                    <h2 class="text-info text-uppercase"  style="margin-bottom: 15px;">Thông tin chi tiết sản phẩm</h2>
                    <p>Thương hiệu: <b>{{$product->brand}}</b></p>
                    {!! $product->description !!}

                    {{--Từ khóa tìm kiếm--}}
                    <a class="text-primary" href="#">#{{$product->meta_keywords}}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
