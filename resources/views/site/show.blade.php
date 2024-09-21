@extends('site.template')
@section('content')
<script src="https://www.youtube.com/iframe_api"></script>
<div class="flex flex-col items-center text-center gap-2 font-bold text-white text-4xl">
    <h2>Aniversário do(a)</h2>
    <h1 class="text-yellow-300 font-extrabold text-5xl">{{ $site->name }}</h1>
    <h3>Parabens pelos seus</h3>
    <h2 class="text-yellow-300 font-extrabold text-5xl">{{ $site->age }} anos</h2>
</div>
<button id="playButton" onclick="toggleAudio()" class="bg-yellow-300 w-full p-2 rounded-lg shadow mt-5 flex justify-center items-center gap-1 hover:bg-yellow-400">
    Tocar Música
</button>
<div id="imageCarousel" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="2500">
    <div class="carousel-inner">
        @foreach($site->images as $index => $image)
        <div class="carousel-item rounded-lg @if($index == 0) active @endif">
            <img src="{{ asset($image->path) }}" class="d-block w-100 rounded-xl border-4 border-yellow-300" alt="Image {{ $index + 1 }}">
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>
<p class="text-center mt-3 text-white font-semibold">
    {{ $site->message->body }}
</p>
<div id="youtube-player" class=""></div>
<script>
    var player;
    var videoId = "{{ $site->music }}";
    var isPlaying = false;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('youtube-player', {
            height: '0',
            width: '0',
            videoId: videoId,
            events: {
                'onReady': onPlayerReady,
                'onStateChange' : onPlayerStateChange
            }
        });
    }

    function onPlayerReady(event) {
        event.target.playVideo();
    }

    function toggleAudio() {
        if (isPlaying) {
            player.pauseVideo();  // Pausa o vídeo
        } else {
            player.playVideo();  // Toca o vídeo
        }
    }

    function onPlayerStateChange(event){
        if(event.data === YT.PlayerState.PLAYING){
            isPlaying = true;
            document.getElementById('playButton').textContent = 'Musica Tocando...';
        }else if (event.data === YT.PlayerState.PAUSED || event.data === YT.PlayerState.ENDED) {
            isPlaying = false;
            document.getElementById('playButton').textContent = 'Tocar Musica';
        }
    }
</script>
@endsection
