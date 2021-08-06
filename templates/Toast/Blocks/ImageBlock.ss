<%------------------------------------------------------------------
Image block
------------------------------------------------------------------%>
<% if $Image %>

<section class="imageBlock">
    <div class="imageBlock__wrap [ js-in-view ]">
    
            <img class="[ lazyload ]" data-src="{$Image.FocusFill(1920,1080).URL}" alt="$Image.Title">

        <% if $Caption %>
            <div class="imageBlock__wrap__caption">
                <p>$Caption</p>
            </div>
        <% end_if %>
    </div>
</section>

<% end_if %>