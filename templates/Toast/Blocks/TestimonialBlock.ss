<%------------------------------------------------------------------
Testimonial block
------------------------------------------------------------------%>

<% if $Items.Count %>
    <section class="testimonialBlock contentBlock">
        
        <div class="testimonialBlock__wrap">

            <% if $Heading %>
                <h3>$Heading.XML</h3>
            <% end_if %>

            <%------------------------------------------------------------------
            Testimonial slider
            ------------------------------------------------------------------%>
            <div class="<% if $ShowSlider %>[ js-slider--testimonials ] slider<% else %>stack<% end_if %>">
                <% loop $Items %>

                    <%------------------------------------------------------------------
                    Testimonial item
                    ------------------------------------------------------------------%>
                    <div class="testimonialBlock__wrap__item item">

                        <div class="testimonialBlock__wrap__item__quote">
                            <p>$Testimonial.XML</p>
                        </div>
                        <div class="testimonialBlock__wrap__item__credit">
                            <% if $Author %>
                                <p><span>$Author.XML</span></p>
                            <% end_if %>
                        </div>
                    </div>
                <% end_loop %>

            </div>

        </div>

    </section>
<% end_if %>