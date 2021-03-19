$Columns

<% if $Items %>
    <% loop $Items %>
        <% if $LinkID %>
            $Link.LinkURL
        <% else %>
            $AbsoluteLink
        <% end_if %>

        $Title.XML
        $Image
        $Blocks__ContentSummary.LimitCharacters(50)
    <% end_loop %>
<% end_if %>