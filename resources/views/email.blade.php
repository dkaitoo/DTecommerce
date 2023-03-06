<!DOCTYPE html>
<html>
<head>
    <title>DT ecommerce</title>
</head>
<body>
<h1>{{ $mailData['title'] }}</h1>
<p>{{ $mailData['body'] }}</p>

<p>Đường link truy cập đến trang web chúng tôi, <a href="{{route('home')}}">Nhấn vào đây</a></p>

<p>Xin chân thành cảm ơn.</p>
</body>
</html>
