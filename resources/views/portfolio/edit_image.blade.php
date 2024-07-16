<!-- resources/views/portfolio/edit_image.blade.php -->
<form action="{{ route('portfolio.update_image', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control">
        @if($post->image)
   
        <img src="{{ route('portfolio_images', $post->image) }}" alt="{{ $post->title }}">

@endif

    </div>
    <button type="submit">Update Image</button>
</form>
