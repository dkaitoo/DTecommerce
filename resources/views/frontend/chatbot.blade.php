<!doctype html>
<html>
<head>
    <title>BotMan Widget</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        html, body {
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        #botmanChatRoot, #userText{
            background-color: #fff !important;
            color: #636b6f;
        }
        #botmanChatRoot{
            height: 400px;
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        }
    </style>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
{{--    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>--}}
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
{{--<script id="botmanWidget" src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/chat.js'></script>--}}
<script id="botmanWidget" src="{{ asset('js/chatbot.min.js') }}"></script>
<script>
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });
    $( function() {
        var availableTags = [
            "Xin chào",
            "Bán gì",
            "Mua hàng, đặt hàng",
            "Chăm sóc, hỗ trợ",
            "Đánh giá, bình luận",
            "Nâng cấp thành nhà bán hàng, muốn bán hàng",
            "Thanh toán sản phẩm",
            "Tiền mặt, COD, thanh toán khi nhận hàng",
            "Online, thẻ, ngân hàng",
            "Tạo tài khoản, đăng ký",
            "Đăng nhập",
            "Quên mật khẩu",
            "Đổi mật khẩu",
            "Tình trạng đơn hàng",
            "Tìm kiếm",
            "Thêm sản phẩm",
            "Cập nhật sản phẩm, sửa sản phẩm, chỉnh sản phẩm",
            "Xóa sản phẩm",
            "Loại sản phẩm, loại hàng",
            "Nhắn tin, trò chuyện, trao đổi",
            "Cập nhật thông tin, cập nhật tài khoản",
        ];
        $( "#userText" ).autocomplete({
            source: availableTags,
            open: function (event, ui) {// Code to open it at top left of the input.
                var $input = $(event.target);
                var $results = $input.autocomplete("widget");
                var scrollTop = $(window).scrollTop();
                var top = $results.position().top;
                var height = $results.outerHeight();
                if (top + height > $(window).innerHeight() + scrollTop) {
                    newTop = top - height - $input.outerHeight();
                    if (newTop > scrollTop)
                        $results.css("top", newTop + "px");
                }
            }
        });
        $(window).scroll(function (event) {// Change position in the scroll event
            $('.ui-autocomplete.ui-menu').position({
                my: 'left bottom',
                at: 'left top',
                of: '#tags'
            });
        });
    } );
</script>
</body>
</html>
