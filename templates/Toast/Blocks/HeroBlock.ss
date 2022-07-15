<%-- -------------------------------------------- 
Hero block
-------------------------------------------- --%>

<section class="hero-block">
    <div class="hero-block__wrap">

        <% if $BackgroundImage %>
            <div class="hero-block__wrap__background">
                <img src="$BackgroundImage.FocusFill(1920,1080).URL" width="1920" height="1080" loading="lazy" alt="$BackgroundImage.alt">
            </div>
        <% end_if %>

        <div class="hero-block__wrap__content hero-block__wrap__content--{$Width}">
            <div class="hero-block__wrap__content__constraint">
                $Content
            </div>
        </div>

    </div>
</section>
