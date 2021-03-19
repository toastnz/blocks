$Columns
<% if $Items.Count %>
    <% loop $Items.Sort('SortOrder') %>
        $Link
        $Icon
        $Image
        $Title.XML
        $Summary.XML
    <% end_loop %>
<% end_if %>