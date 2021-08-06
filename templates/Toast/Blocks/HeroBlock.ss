<section class="heroBlock contentBlock [ js-hero-block ]">

    <% if $BackgroundImage %>
        <div class="heroBlock__container">
            <div class="heroBlock__container__background [ js-hero-block-image ][ lazyload ]" data-bgset="{$BackgroundImage.FocusFill(1920,1080).URL}" style="background-position: $BackgroundImage.PercentageX% $BackgroundImage.PercentageY%;"></div>
        </div>
    <% end_if %>

    <div class="heroBlock__wrap">

        <div class="heroBlock__wrap__content">
            $Content
        </div>

    </div>
</section>
