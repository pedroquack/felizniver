@extends('site.template')
@section('content')
    <h1 class="font-bold text-3xl text-white text-center">Parabens, seu site foi criado!</h1>
    <h2 class="text-lg text-center">Um email foi enviado para: <span class="font-bold">{{ $email }}</span> com a URL do site e um QR Code para compartilhar!</h2>
@endsection
