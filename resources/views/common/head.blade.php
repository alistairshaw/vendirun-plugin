<title>{{ $page->title or 'Welcome' }}</title>

<meta charset="utf-8">
<meta name="description" content="{{ $page->meta_description or '' }}">
<meta name="keywords" content="{{ $page->meta_keywords or '' }}">
<meta name="robots" content="follow,index">
<meta name="author" content="Vendirun">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="{{ asset('vendor/vendirun/css/production.css') }}">