<% if $Items %>
    <section class="downloadBlock contentBlock" data-equalize>
        <div class="downloadBlock__wrap row">
            <div class="column">
                <% loop $Items.Sort('SortOrder') %>
                    <% with $File %>
                        <a href="{$AbsoluteLink}" download class="column downloadBlock__wrap__item">
                            <div class="downloadBlock__wrap__item__heading" data-equalize-watch>
                                <h5 class="downloadBlock__wrap__item__heading__title title">$Title</h5>
                                <% if $Up.Summary %>
                                    <div class="downloadBlock__summary">
                                        $Up.Summary.XML
                                    </div>
                                <% end_if %>
                                <h6 class="downloadBlock__wrap__item__heading__info info">$MimeType, $Size</h6>
                                <div class="icon">$SVG('download')</div>
                            </div>
                        </a>
                    <% end_with %>
                <% end_loop %>
            </div>
        </div>
    </section>
<% end_if %>
