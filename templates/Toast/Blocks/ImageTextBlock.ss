<%----------------------------------------------------------------
Image and Text Block
----------------------------------------------------------------%>

<div class="imageText <% if $ReverseLayout %>imageText--reversed<% end_if %>">
    <div class="imageText__wrap">

        <div class="imageText__wrap__image" data-parallax="<% if $ReverseLayout %>.2<% else %>-.2<% end_if %>">
            $Image.FocusFill(1200,800)
            <% if $ImageText %>
            <div class="imageText__wrap__image__text">
                <h4 class="colour--white">$ImageText</h4>
            </div>
            <% end_if %>

            <div class="animatedPanel [ js-in-view ]">
                <div class="animatedPanel__colour"></div>
            </div>
        </div>

        <div class="imageText__wrap__text" data-parallax="<% if $ReverseLayout %>-.2<% else %>.2<% end_if %>">
            $Content
        </div>
    </div>
</div>