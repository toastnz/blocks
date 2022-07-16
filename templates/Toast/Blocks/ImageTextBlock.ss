<%-- -------------------------------------------- 
Image and text block
-------------------------------------------- --%>

<div class="image-text <% if $ReverseLayout %>image-text--reversed<% end_if %>">
    <div class="image-text__wrap image-text__wrap--{$Width}">

        <% if $Image %>
            <div class="image-text__wrap__image">
                <img src="$Image.FocusFill(1200,800).URL" width="1200" height="800" loading="lazy">
            </div>
        <% end_if %>
        
        <div class="image-text__wrap__text">
            {$Content}
        </div>

    </div>
</div>