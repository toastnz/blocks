<% if $Testimonials.Count %>
    <% if $ShowSlider %><% end_if %>
    
    <% loop $Testimonials %>
        $Testimonial.XML
        <% if $Up.ShowNameAndLocation %>
            $Title.XML
            $Location.XML
        <% end_if %>
    <% end_loop %>
<% end_if %>