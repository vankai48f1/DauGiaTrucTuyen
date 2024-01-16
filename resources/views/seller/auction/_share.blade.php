<div class="border p-3 mt-3 clearfix">
    <div class="pull-left px-2">
        <h3 class="my-2 mb-0 color-666">{{ __('Share This Auction') }}</h3>
    </div>
    <div class="pull-right px-2">
        <a class="btn lf-toggle-border border" href="https://www.facebook.com/sharer.php?u={{ urlencode(url()->current()) }}&amp;t={{ urlencode($auction->title) }}" target="_blank">
            <i class="fa fa-facebook"></i>
        </a>
        <a class="btn lf-toggle-border border" href="https://twitter.com/share?text={{ urlencode($auction->title) }}&amp;url={{ urlencode(url()->current()) }}" target="_blank" >
            <i class="fa fa-twitter"></i>
        </a>
        <a class="btn lf-toggle-border border" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ url($auction->title) }}&amp;" target="_blank">
            <i class="fa fa-linkedin"></i>
        </a>
        <a class="btn lf-toggle-border border" href="mailto:?subject={{ urlencode($auction->title) }}&amp;body={{ urlencode(url()->current()) }}" target="_self" rel="noopener noreferrer">
            <i class="fa fa-envelope"></i>
        </a>
    </div>
</div>
