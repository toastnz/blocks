<% if $Tabs %>
<section class="tabbed-block block [ js-tabs ]">
    <div class="tabbed-block__wrap">

        <div class="tabbed-block__wrap__tabs">
            
            <div class="tabbed-block__wrap__tabs__indicator [ js-tabbed-indicator ]"></div>
            
            <% loop $Tabs %>
                <a href="#" class="tabbed-block__wrap__tabs__item [ js-tabs-link ] <% if $First %>active<% end_if %>">
                    <h6>$Title.XML</h6>
                </a>
            <% end_loop %>
        </div>

        <div class="tabbed-block__wrap__content">
            <% loop $Tabs %>
            <div class="tabbed-block__wrap__content__item [ js-tabs-item ] <% if $First %>active<% end_if %>">
                $Content
            </div>
            <% end_loop %>
        </div>
    </div>
</section>
<% end_if %>

<script>

const updateTabbedContent = (indicator, currentTab) => {

    let parent = currentTab.parentNode;
    let grandparent = parent.parentNode;
    let index = Array.prototype.indexOf.call(parent.children, currentTab);

    currentTab.classList.add('active');

    document.querySelectorAll('.js-tabs-item', grandparent).forEach(tabbedContentItem => tabbedContentItem.style.display = 'none');

    grandparent.querySelector(`.js-tabs-item:nth-child(${index})`).style.display = 'block';

    let rect = currentTab.getBoundingClientRect();
    indicator.style.height = `${rect.height}px`;
    indicator.style.top = `${currentTab.offsetTop}px`;
}

document.querySelectorAll('.js-tabs').forEach(tabbedContent => {

    let indicator = tabbedContent.querySelector('.js-tabbed-indicator');
    let currentTab = tabbedContent.querySelector('.js-tabs-link.active');

    document.querySelectorAll('.js-tabs-link', tabbedContent).forEach(tabbedContentLink => {

        tabbedContentLink.addEventListener('click', (e) => {
            e.preventDefault();
            currentTab.classList.remove('active');
            currentTab = tabbedContentLink;
            updateTabbedContent(indicator, currentTab);
        });

    });

    updateTabbedContent(indicator, currentTab);

});

</script>
