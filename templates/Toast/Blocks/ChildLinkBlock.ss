<% if $Items %>
    <section class="linkBlock linkBlock--{$Columns}">
        <div class="linkBlock__wrap">
            <% loop $Items %>
                <a href="<% if $LinkID %>$Link.LinkURL<% else %>$AbsoluteLink<% end_if %>" class="linkBlock__wrap__item">
                    <div class="linkBlock__wrap__item__details">
                        <% if $Top.Columns == 2 %>
                            <h5>$Title.XML</h5>
                        <% else %>
                            <h6>$Title.XML</h6>
                        <% end_if %>
                    </div>
                    <div class="linkBlock__wrap__item__media media" style="background-image: url('{$Image.fill(640,640).URL}');">
                        <div class="linkBlock__wrap__item__media__content hoverContent">
                            <div class="alignContent">
                                <% if $Blocks__ContentSummary %>
                                    <div class="contentRow">
                                        <div class="verticalAlign verticalAlign--top">
                                            <p>
                                                $Blocks__ContentSummary.LimitCharacters(50)
                                            </p>
                                        </div>
                                    </div>
                                <% end_if %>
                                <div class="contentRow">
                                    <div class="verticalAlign verticalAlign--bottom">
                                        <span class="linkBlock__wrap__item__link link redirect--arrow">Read more</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <% end_loop %>
        </div>
    </section>
<% end_if %>