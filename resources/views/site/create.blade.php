@extends('site.template')
@section('content')
<h1 class="text-white text-5xl font-bold">
    Uma surpresa para alguem
    <span class=" text-yellow-300 text-6xl">QUERIDO</span>
</h1>
<p class="text-white my-3 text-lg">
    Crie uma página para surpreender o aniversáriante, com uma apresentação de imagens, uma mensagem de aniversário e uma
    música de sua escolha + um QR code para compartilhar a pagina!
</p>
<div class="bg-yellow-300 p-1 rounded-lg shadow-lg my-3 text-center font-bold border-4 border-white border-dashed">Por apenas R$9.99</div>
<form action="{{ route('stripe.checkout') }}" method="post" enctype="multipart/form-data">
    <div class="flex flex-col mb-3">
        <label for="name" class="text-white font-semibold">Nome do aniversáriante</label>
        <input type="text" name="name" id="name" class="p-2 rounded-lg border-2 border-yellow-300" placeholder="Ex: Pedro, Augusto, Nicolas" value="{{ old('name') }}">
        @if ($errors->has('name'))
            <span class="text-red-600 font-bold">{{ $errors->first('name') }}</span>
        @endif
    </div>
    <div class="flex flex-col mb-3">
        <label for="age" class="text-white font-semibold">Quantos anos vai fazer</label>
        <input type="number" min="0" name="age" id="age" class="p-2 rounded-lg border-2 border-yellow-300" placeholder="Ex: 12,19,24" value="{{ old('age') }}">
        @if ($errors->has('age'))
            <span class="text-red-600 font-bold">{{ $errors->first('age') }}</span>
        @endif
    </div>
    <div class="flex flex-col mb-3">
        <label for="body" class="text-white font-semibold">Mensagem de aniversário</label>
        <textarea type="text" name="body" id="body" class="p-2 rounded-lg border-2 border-yellow-300 min-h-24" placeholder="Ex: Feliz aniversário caro amigo, muitos anos de vida">{{ old('body') }}</textarea>
        @if ($errors->has('body'))
            <span class="text-red-600 font-bold">{{ $errors->first('body') }}</span>
        @endif
    </div>
    <div class="flex flex-col mb-3">
        <label for="music" class="text-white font-semibold">Link da musica (youtube)</label>
        <input type="url" name="music" id="music" class="p-2 rounded-lg border-2 border-yellow-300" value="{{ old('music') }}">
        @if ($errors->has('music'))
            <span class="text-red-600 font-bold">{{ $errors->first('music') }}</span>
        @endif
    </div>
    <div class="flex flex-col mb-3">
        <label for="images" class="text-white font-semibold">Escolha até 5 imagens</label>
        <input type="file" name="images[]" id="images" multiple class="bg-white p-2 rounded-lg border-2 border-yellow-300 ">
        @if ($errors->has('images'))
            <span class="text-red-600 font-bold">{{ $errors->first('images')}}</span>
        @endif
    </div>
    <button class="bg-yellow-300 p-3 w-full rounded-lg hover:bg-yellow-400 transition font-bold">
        Criar site
    </button>

</form>
@endsection
