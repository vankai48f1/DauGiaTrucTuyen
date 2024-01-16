@if($auction->meta_description)
    <meta name="description" content="{{ $auction->meta_description }}">
    <meta property="og:description"
          content="{{ $auction->meta_description }}"/>
    <meta name="twitter:description" content="{{ $auction->meta_description }}">
@endif

@if(!empty($auction->meta_keywords))
    <meta name="keywords" content="{{ array_to_string($auction->meta_keywords, ',', false) }}">
@endif

<meta name="author" content="{{ !empty(settings('company_name')? settings('company_name'): env('APP_NAME')) }}">

<meta property="og:url"
      content="{{ url()->current() }}"/>

@if(!empty($auction->images) && count($auction->images) > 0)
    <meta property="og:image"
          content="{{ auction_image($auction->images[0]) }}"/>
    <meta property="og:image:secure_url"
          content="{{ auction_image($auction->images[0]) }}"/>
@endif

<meta property="og:site_name" content="{{ !empty(settings('company_name')? settings('company_name'): env('APP_NAME')) }}">
<meta property="og:title" content="{{ $auction->title }}">
<meta property="og:type" content="auction">

<meta property="og:price:amount" content="{{ $auction->bid_initial_price }}">
<meta property="og:price:currency" content="{{ $auction->currency_symbol }}">
<meta name="twitter:site" content="@">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $auction->title }}">
