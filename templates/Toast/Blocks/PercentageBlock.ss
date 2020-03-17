<section class="percentageBlock contentBlock" style="background-image: url('{$DefaultImage.Fill(1920,1080).URL}');">
    <div class="percentageBlock__wrap row xmd-up-alignContent <% if $FullWidth %>collapse<% end_if %>" data-equalize>
        <% include Toast\Includes\PercentageBlock__Content Position='left', Width=$getWidth('left'), Media=$LeftBackgroundImageURL, FullWidth=$FullWidth, Content=$LeftContent, Link=$LeftLink %>
        <% include Toast\Includes\PercentageBlock__Content Position='right', Width=$getWidth('right'), Media=$RightBackgroundImageURL, FullWidth=$FullWidth, Content=$RightContent, Link=$RightLink %>
    </div>
</section>
