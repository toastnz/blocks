<section class="slider-block" id="slider-block-{$ID}">

    <div class="slider-block__heading">
        <h2 class="text-center">$Heading</h2>
    </div>

    <div class="slider-block__wrap">

        <div class="slider-block__slider [ js-slider-block-{$ID} ]">
            <% loop $Slides %>
                <div class="slider-block__slider__item" data-index="$Pos">
                    <div class="slider-block__slider__item__image">
                        <% if $Image %>
                            <img src="$Image.focusFill(450,400).URL" loading="lazy" width="450" height="400" alt="$Title">
                        <% end_if %>
                    </div>
                    <div class="slider-block__slider__item__copy">
                        <h4 class="colour--secondary">$Title</h4>
                        <p>$Content</p>
                        <a href="$AbsoluteLink" class="arrow-link"><span></span>READ MORE</a>
                    </div>
                </div>
            <% end_loop %>
        </div>
    </div>

</section>


<% if $Slides.count > 1 %>

<script defer async src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css" media="print" onload="this.media='all'">

<script>
document.addEventListener("DOMContentLoaded", function() {
    tns({
      container:".js-slider-block-{$ID}" ,
      items: 2,
      mouseDrag: true,
      nav: false,
      center:true,
      controls: true,
      slideBy: 1,
      loop: true,
      responsive:{
        768:{
          items:3
        }
      }
    });
  });

</script>

<style> 
  .tns-slider {
      display: flex;
  }
</style>
<% end_if %>
