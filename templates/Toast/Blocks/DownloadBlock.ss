<%----------------------------------------------------------------
Download Block
----------------------------------------------------------------%>
<% if $Items %>
    <section class="download-block block">
        <div class="download-block__wrap">

            <div class="download-block__wrap__list">

                <% loop $Items.Sort('SortOrder') %>
 
                    <%----------------------------------------------------------------
                    Download Block Item
                    ----------------------------------------------------------------%>
                    <% with $File %>
                        <a href="{$AbsoluteLink}" class="download-block__wrap__list__item">

                            <div class="download-block__wrap__list__item__icon">
                                $SVG('download')
                            </div>

                            <div class="download-block__wrap__list__item__details">
                                <h6 class="download-block__wrap__list__item__details__title">{$Title}</h6>

                                <% if $Up.Summary %>
                                    <div class="download-block__wrap__list__item__details__summary">
                                        $Up.Summary.XML
                                    </div>
                                <% end_if %>

                                <p class="download-block__wrap__list__item__details__extension">{$Extension.upperCase} {$Size}</p>
                            </div>
                                
                        </a>
                    <% end_with %>
                <% end_loop %>
            </div>
        </div>
    </section>
<% end_if %>
