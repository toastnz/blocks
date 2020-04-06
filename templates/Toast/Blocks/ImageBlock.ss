<%------------------------------------------------------------------
Image block
------------------------------------------------------------------%>
<% if $Image %>

<section class="imageBlock contentBlock">
    <div class="imageBlock__wrap [ js-in-view ]">
        <picture>
            <source media="(min-width: 1200px)" srcset="$Image.FocusFill(1920,1080).URL">
            <source media="(min-width: 800px)" srcset="$Image.FocusFill(960,540).URL">
            <source media="(min-width: 320px)" srcset="$Image.FocusFill(480,270).URL">
            <img src="$Image.FocusFill(1920,1080).URL" alt="$Image.Title">
        </picture>

        <% if $Caption %>
            <div class="imageBlock__wrap__caption ">
                <p>$Caption</p>
            </div>
        <% end_if %>
    </div>
</section>

<% end_if %>