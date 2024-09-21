<!DOCTYPE html>
<html>
<head>
    <style>
        .site-url{
            margin: auto;
            padding: 4px;
            width: 50%;
            text-align: center;
            margin-top: 3px;
            margin-bottom: 3px;
            border-radius: 15px;
            background-color: rgb(235, 235, 235)
        }
        .site-url a{
            font-weight: bold;
        }

        .qr-code{
            margin: auto;
            padding: 12px;
            width: 50%;
            border-radius: 15px;
            background-color: rgb(235, 235, 235)
        }
    </style>
</head>
<body>
    <h1>Obrigado pela sua compra!</h1>
    <p>Desejamos um feliz aniversário para {{ $site->name }}, que venham muitos anos de vida e muita felicidade! Segue
        abaixo, respectivamente, o link para seu site e o QR Code para compartilhar</p>
    <div class="site-url">
        <a href="{{ route('site.show',[$site->id,$site->name]) }}">{{ route('site.show',[$site->id,$site->name]) }}</a>
    </div>
    <div class="qr-code">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ route('site.show',[$site->id,$site->name]) }}"
            id="qr-code">
    </div>
</body>

</html>
