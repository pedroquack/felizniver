<form action="{{ route('stripe.checkout') }}" method="post">
    @csrf
    <input type="text" name="name">
    <input type="number" name="age" id="age">
    <textarea name="body" id="body" cols="30" rows="10"></textarea>
    <input type="url" name="music" id="music">
    <button type="submit">Submit</button>
</form>
