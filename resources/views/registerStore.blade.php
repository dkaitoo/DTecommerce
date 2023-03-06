<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký nhà bán hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.css" integrity="sha512-9j3GcomYXBnTpYYxgqV2U8wxkJ8tWkzz55b/LDhX1RYQ4DF36slQJQt+OXj9W28KEsZlJYUTck0X6IeE+IiP8Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('css/upSeller.css') }}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
</head>
<body>
{{--Them bootstrap de chay cai nay--}}
@include('flash-message')
    <div class="wrapper">
        <form action="{{route('sellerFormAdd')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="wizard">
                <div class="row">
                    <a href="{{route('home')}}" class="text-info"><i class="col-md-1 fa fa-solid fa-2x fa-angle-left mb-3"></i></a>
                <!-- SECTION 1 -->
                    <h4 class="title col-md-10">ĐĂNG KÝ TRỞ THÀNH NHÀ BÁN HÀNG</h4>
                </div>

                <section>
                    <div class="form-header">

                        <div class="avartar">
                            <a href="#" style="text-align: center;">
                                <img src="{{asset('/img/Default_store.png')}}" id="profile-img-tag" alt="" style="width: 120px; height: 120px; border-radius: 50%;">
                            </a>
                            <div class="avartar-picker">
                                <input type="file" name="logo" id="profile-img" accept="image/*" class="inputfile" />
                                <label for="profile-img">
                                    <i class="zmdi zmdi-camera"></i>
                                    <span>Chọn logo cửa hàng</span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-holder active">
                                <input type="text" placeholder="Họ và tên" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-holder">
                                <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')" name="identity_card"  maxlength="12" value="{{ old('identity_card') }}" placeholder="CMND/CCCD" class="form-control">
                            </div>
                            <div class="form-holder">
                                <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '')"  name="phone" maxlength="10" value="{{ old('phone') }}" placeholder="Số điện thoại" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-holder">
                        <input type="text" placeholder="Email" class="form-control" name="email" value="{{$user->email}}" readonly>
                    </div>
                    <div class="form-holder">
                        <input type="text" name="store_name" value="{{ old('store_name') }}" placeholder="Tên cửa hàng" class="form-control">
                    </div>
                    <div class="form-holder">
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Địa chỉ cửa hàng" class="form-control">
                    </div>
                    <button class="btn-a" type="submit" name="register" value="submit">Submit</button>
                </section>
            </div>
        </form>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js" integrity="sha512-bE0ncA3DKWmKaF3w5hQjCq7ErHFiPdH2IGjXRyXXZSOokbimtUuufhgeDPeQPs51AI4XsqDZUK7qvrPZ5xboZg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(function(){
        // Input Focus
        $('.form-holder').delegate("input", "focus", function(){
            $('.form-holder').removeClass("active");
            $(this).parent().addClass("active");
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile-img").change(function(){
        readURL(this);
    });
</script>
</body>
</html>
