<%------------------------------------------------------------------
Testimonial block
------------------------------------------------------------------%>

<% if $Items.Count %>
    <section class="testimonials">
        
        <div class="testimonials__wrap">

            <div class="testimonials__wrap__heading">
                <% if $Heading %>
                    <h3>$Heading.XML</h3>
                <% end_if %>
            </div>
            
            <%------------------------------------------------------------------
            Testimonial slider
            ------------------------------------------------------------------%>
            <div class="testimonials__wrap__slider [ js-slider-testimonials-{$ID} ]">
                <% loop $Items %>

                    <%------------------------------------------------------------------
                    Testimonial item
                    ------------------------------------------------------------------%>
                    <div class="testimonials__wrap__slider__item">

                        <div class="testimonials__wrap__slider__item__quote">
                            <p>$Testimonial.XML</p>
                        </div>

                        <% if $Author %>
                            <div class="testimonials__wrap__slider__item__credit">
                                <p class="colour--primary"><span>$Author.XML</span></p>
                            </div>
                        <% end_if %>

                    </div>
                <% end_loop %>

            </div>

        </div>

    </section>
<% end_if %>


<script defer async src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css" media="print" onload="this.media='all'">

<script>
document.addEventListener("DOMContentLoaded", function() {
    tns({
      container:".js-slider-testimonials-{$ID}" ,
      items: 1,
      mouseDrag: true,
      nav: true,
      controls: true,
      slideBy: 1,
      mode: 'gallery',
      loop: true
    });
  });

</script>

<style> 
  .tns-slider {
      display: flex;
  }
</style>