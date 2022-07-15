<%-- -------------------------------------------- 
Accordion block
-------------------------------------------- --%>

<section class="accordion">

    <div class="accordion__wrap">

        <% loop $Items %>

            <%-- -------------------------------------------- 
            Accordion item
            -------------------------------------------- --%>

            <div class="accordion__wrap__item" id="accordion_{$Pos}_{$ID}">

                <div href="#" class="accordion__wrap__item__heading" onclick="toggleActive('accordion_{$Pos}_{$ID}')">
                    <h5 class="accordion__wrap__item__heading__title">$Title</h5>
                </div>

                <div class="accordion__wrap__item__content">
                    <div class="accordion__wrap__item__content__inner">
                        $Content
                    </div>
                </div>

            </div>

            <% end_loop %>

    </div>
</section>

<script>

    /**
     * Simple accordion toggle section
     * @param {string} id 
     */
    function toggleActive(id) {

        // Get the accordion heading
        var accordion = document.getElementById(id);

        // Get the accordion content
        var content = accordion.querySelector('.accordion__wrap__item__content');

        // Toggle the active class on the accordion
        if (!accordion.classList.contains('active')) {

            // Add active class to the accordion
            accordion.classList.add('active');

            // Quickly get the height we want to animate to
            content.style.height = 'auto';
            var height = content.clientHeight + 'px';

            // Revert the heioght back to nothing
            content.style.height = 0;

            // Animate the height once the calculations are done
            setTimeout(function () {
                content.style.height = height;
            }, 0);

        } else {

            // Revert the height back to nothing
            content.style.height = 0;

            // Remove the active class once animations are over
            content.addEventListener('transitionend', function () {
                accordion.classList.remove('active');
            }, { once: true });

        }

    }
</script>