<% if $Items.Count %>
    $Content

    <% loop $Items.Sort('SortOrder') %>
        $Link
        $Image
        $FeaturedImage
        $Title
        $Content
    <% end_loop %>
<% end_if %>