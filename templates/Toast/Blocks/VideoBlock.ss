<%----------------------------------------------------------------
Video Block
----------------------------------------------------------------%>

<section class="videoBlock">
    <a href="#" class="videoBlock__wrap  [ js-video-modal ]" data-video-id="$Video">

        <% if $ThumbnailID %>
            <img alt="$Thumbnail.Title" data-sizes="auto" data-src="$Thumbnail.FocusFill(640,360).URL" data-srcset="$Thumbnail.FocusFill(640,360).URL 640w,  $Thumbnail.FocusFill(1920,1080).URL 1920w" class="videoBlock__wrap__background [ lazyload ]">
        <% else %>
            <img alt="Video Thumbnail" width="640" height="360" src="$Video.ThumbnailURL" srcset="$Video.ThumbnailURL" class="videoBlock__wrap__background [ lazyload ]">
        <% end_if %>

        <div class="videoBlock__wrap__icon">$SVG('play')</div>
    </a>
</section>
