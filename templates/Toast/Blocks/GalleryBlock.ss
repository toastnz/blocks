<% if $GalleryImages %>
    <section class="sliderBlock contentBlock [ js-sliderGallery ]" data-block-id="{$ID}">
        <div class="sliderBlock__wrap row">
            <div class="column">
                <div class="sliderBlock__wrap__slider row">
                    <div class="[ js-sliderGallery--main ]">
                        <% loop $GalleryImages.Sort('SortOrder') %>
                            <div class="sliderBlock__wrap__slider__item column">
                                <img class="sliderBlock__wrap__slider__item__media" src="{$GalleryImage.URL}" alt="{$Title.XML}">
                            </div>
                        <% end_loop %>
                    </div>
                </div>
                <% if $GalleryImages.Count >= 2 %>
                    <% if $ShowThumbnail %>
                        <div class="sliderBlock__wrap__nav">
                            <div class="[ js-sliderGallery--nav init-up-3 sm-up-4 xmd-up-5 lg-up-6 xl-up-7 ]">
                                <% loop $GalleryImages.Sort('SortOrder') %>
                                    <div class="sliderBlock__wrap__nav__item [ js-sliderGallery--nav-item ]">
                                        <% if $GalleryImage %>
                                            <div class="sliderBlock__wrap__nav__item__media" style="background-image: url('{$GalleryImage.Fill(200,200).URL}');"></div>
                                        <% else %>
                                            <div class="sliderBlock__wrap__nav__item__media" style="background-image: url('https://via.placeholder.com/200x200');"></div>
                                        <% end_if %>
                                    </div>
                                <% end_loop %>
                            </div>
                        </div>
                    <% end_if %>
                <% end_if %>
            </div>
        </div>
    </section>
<% end_if %>

