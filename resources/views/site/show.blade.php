@foreach ($site->images as $item)
    <img src="{{ asset($item->path) }}" alt="">
@endforeach
