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
                        <img src="{$Themedir}/dist/images/svg/quotes.svg" width="88" height="72" loading="lazy">

                        <div class="testimonials__wrap__slider__item__testimonial">
                            <h6 class="colour--white">$Testimonial.XML</h6>
                        </div>

    
                        <div class="testimonials__wrap__slider__item__credit">
                            <% if $Author %>
                                <p class="colour--white"><b>$Author.XML</b></p>
                            <% end_if %>
                            <% if $Description %>
                                <p class="colour--white smaller">$Description.XML</p>
                            <% end_if %>
                        </div>

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