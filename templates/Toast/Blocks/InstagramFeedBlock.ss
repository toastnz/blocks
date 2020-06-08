<%------------------------------------------------------------------
Instagram Feed block
------------------------------------------------------------------%>
<section class="instagramFeedBlock contentBlock">
    <div class="instagramFeedBlock__wrap">

        <% if $Content %>
            <div class="instagramFeedBlock__wrap__content ">
                $Content
            </div>
        <% end_if %>

        <% if $InstagramFeed %>
            <% with $InstagramFeed %>
                <% loop $Items.limit($Up.getItemsLimit) %>
                    <a href="{$Link}" class="instagram__wrap__item">
                        <img src="$ThumbURL">
                    </a>
                <% end_loop %>
            <% end_with %>
        <% end_if %>

    </div>
</section>

