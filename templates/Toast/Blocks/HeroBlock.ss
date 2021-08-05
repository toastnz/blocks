<section class="heroBlock contentBlock [ js-hero-block ]">

    <% if $BackgroundImage %>
        <div class="heroBlock__container">
            <div class="heroBlock__container__background [ js-hero-block-image ]" style="background-image: url('{$BackgroundImage.FocusFill(1920,1080).URL}');"></div>
        </div>
    <% end_if %>

    <div class="heroBlock__wrap">

        <div class="heroBlock__wrap__content">
            $Content
        </div>

    </div>
</section>
