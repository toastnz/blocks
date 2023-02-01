<% if $Items %>
    <section class="link-block block">

        <div class="link-block__wrap link-block__wrap--{$Width} link-block__wrap--{$Columns}">
            
            <% loop $Items.Sort('SortOrder') %>
                <a href="$Link" class="link-block__wrap__item <% if not $Icon && not $image %>bordered <% end_if %>">

                    <% if $Icon %>
                        <div class="link-block__wrap__item__icon">
                            <img src="$Icon.URL">
                        </div>
                    <% else_if $Image %>
                        <img  class="link-block__wrap__item__image" src="$Image.FocusFill(600,300).URL" width="600" height="300" loading="lazy">
                    <% end_if %>

                    <div class="link-block__wrap__item__content">
                        <div class="link-block__wrap__item__content__heading">
                            <h6>$Title.XML</h6>
                        </div>
                        <p>$Blocks__ContentSummary.LimitCharacters(50)</p>
                        <p class="link-block__wrap__item__content__link arrow-link">
                            Read More 
                        </p>
                    </div>

                </a>
            <% end_loop %>

        </div>

    </section>
<% end_if %>
