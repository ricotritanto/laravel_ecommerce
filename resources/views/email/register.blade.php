<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Pendaftaran Anda</title>
</head>
<body>
    <h2>Hai, {{ $customer->name}}</h2>
    <p>Terima kaih telah melakukan transaki pada aplikasi kami, berikut password anda: <strong>{{$password}}</stong></p>
    <p>Jangan lupa untuk melakukan verifikasi pendaftaran <a href="{{route('customer.verify', $customer->activate_token)}}" class="">DISINI</a>
</body>
</html>