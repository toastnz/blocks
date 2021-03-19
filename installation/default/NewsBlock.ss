$Content
<% if $Items.Count %>
    <% loop $Items.Sort('SortOrder') %>
        <% if $Link %>
            $Link
            $FeaturedImage
            $Title.XML
            <% if $Image %>
                $Image
            <% end_if %>
            $Content
        <% end_if %>
    <% end_loop %>
<% end_if %>