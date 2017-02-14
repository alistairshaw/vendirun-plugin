<div class="vendirun-twitter-feed">
    <h3>{{ trans('vendirun::widgets.twitterFeedFor') }} <a href="https://twitter.com/{{ $twitterHandle }}" target="_blank">{{ '@' . $twitterHandle }}</a></h3>
    @foreach ($tweets as $tweet)
        <div class="tweet">
            <div class="photo"><img src="{{ $tweet->user->profile_image_url_https }}"></div>
            <div class="body">
                <div class="header">
                    <div class="name">{{ $tweet->user->name }}</div>
                    <div class="handle">{{ $tweet->user->screen_name }}</div>
                    <div class="date">{{ $tweet->created_at }}</div>
                </div>
                <div class="content">
                    {{ $tweet->text }}
                </div>
            </div>
        </div>
    @endforeach
</div>