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

        <% if $Blocks__ContentSummary %>
            $Blocks__ContentSummary.LimitCharacters(50)
        <% end_if %>
    <% end_loop %>
<% end_if %>