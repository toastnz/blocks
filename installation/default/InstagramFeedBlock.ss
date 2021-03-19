$Content
<% if $InstagramFeed %>
    <% with $InstagramFeed %>
        <% loop $Items.limit($Up.getItemsLimit) %>
            $Link
            $ThumbURL
        <% end_loop %>
    <% end_with %>
<% end_if %>