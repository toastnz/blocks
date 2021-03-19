<% if $Items %>
    <% loop $Items.Sort('SortOrder') %>
        <% with $File %>
            $AbsoluteLink
            $Title
            $Up.Summary
            $Extension.UpperCase
            $Size
        <% end_with %>
    <% end_loop %>
<% end_if %>