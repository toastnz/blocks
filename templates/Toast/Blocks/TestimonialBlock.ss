<% if $Testimonials.Count %>
    <section class="testimonialBlock contentBlock">
        <div class="testimonialBlock__wrap row">
            <div class="<% if $ShowSlider %>[ js-slider--testimonials ] slider<% else %>stack<% end_if %>">
                <% loop $Testimonials %>
                    <div class="testimonialBlock__wrap__item item column">
                        <h4 class="testimonialBlock__wrap__item__icon icon">&quot;</h4>
                        <div class="testimonialBlock__wrap__item__quote quote">
                            <p>{$Testimonial.XML}</p>
                        </div>
                        <div class="testimonialBlock__wrap__item__credit credit">
                            <% if $Up.ShowNameAndLocation %>
                                <p><span>{$Title.XML}<% if $Location %>,<% end_if %></span> {$Location.XML}</p>
                            <% end_if %>
                        </div>
                    </div>
                <% end_loop %>
            </div>
        </div>
    </section>
<% end_if %>