$Columns

<% if $Items.Count %>
    <% loop $Items.Sort('SortOrder') %>
        $Link
        $Title.XML
        $Summary.XML
        <% if $Icon %>
            $Icon
        <% else_if $Image %>
            $Image
        <% end_if %>
    <% end_loop %>
<% end_if %>