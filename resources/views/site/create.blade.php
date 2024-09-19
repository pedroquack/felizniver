@extends('site.template')
@section('content')
    <form action="{{ route('stripe.checkout') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name">
        <input type="number" name="age" id="age">
        <textarea name="body" id="body" cols="30" rows="10"></textarea>
        <input type="url" name="music" id="music">
        <input type="file" name="images[]" id="images" multiple>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <button type="submit">Submit</button>
    </form>
@endsection
