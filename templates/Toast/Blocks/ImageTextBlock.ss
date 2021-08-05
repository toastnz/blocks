<%----------------------------------------------------------------
Image and Text Block
----------------------------------------------------------------%>

<div class="imageText <% if $ReverseLayout %>imageText--reversed<% end_if %>"<% if $EnableParallax %>data-parallax<% end_if %> >
<div class="imageText__wrap" >

        <div class="imageText__wrap__image" <% if $EnableParallax %>data-parallax="<% if $ReverseLayout %>.2<% else %>-.2<% end_if %>"<% end_if %>>
            $Image.FocusCropWidth(1200)
        </div>

        <div class="imageText__wrap__text" <% if $EnableParallax %>data-parallax="<% if $ReverseLayout %>-.2<% else %>.2<% end_if %>"<% end_if %>>
            $Content
        </div>
    </div>
</div>  