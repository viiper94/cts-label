<div class="author-locations mt-2">
    @foreach($reviews as $review)
        <small><a class="copy-author">{{ $review->author }}</a> - <a class="copy-author-location">{{ $review->location }}</a></small>
    @endforeach
</div>
