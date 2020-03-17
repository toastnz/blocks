<section class="splitBlock contentBlock--padding">

    <div class="splitBlock__wrap row xmd-up-alignContent xmd-up-2">

        <div class="splitBlock__wrap__item column verticalAlign verticalAlign--top">
            <div class="splitBlock__wrap__item__content">
                <h3>$LeftHeading.XML</h3>

                <% if $LeftImage %>
                    $RightImage.Fill(150,100)
                <% end_if %>

                $LeftContent

                <% if $LeftLink %>
                    <a href="$LeftLink.Link" {$LeftLink.TargetAttr}>$LeftLink.Title.XML</a>
                <% end_if %>
            </div>
        </div>

        <div class="splitBlock__wrap__item column verticalAlign verticalAlign--top">
            <div class="splitBlock__wrap__item__content">
                <h3>$RightHeading.XML</h3>

                <% if $RightImage %>
                    $RightImage.Fill(150,100)
                <% end_if %>

                $RightContent

                <% if $RightLink %>
                    <a href="$RightLink.Link" {$RightLink.TargetAttr}>$RightLink.Title.XML</a>
                <% end_if %>
            </div>
        </div>

    </div>
</section>