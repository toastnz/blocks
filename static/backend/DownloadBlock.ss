<%----------------------------------------------------------------
Download Block
----------------------------------------------------------------%>
<% if $Items %>
    <% loop $Items.Sort('SortOrder') %>
        $Summary.XML

        <% with $File %>
            $AbsoluteLink
            $Title
            $Extension.UpperCase
            $Size
        <% end_with %>
    <% end_loop %>
<% end_if %>