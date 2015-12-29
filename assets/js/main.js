/**
 * Polyfills the agent blocks on the agent archive page so that the
 * absolutely-positioned images don't overflow the container.
 */
function agentSizer() {
    if ( jQuery('body').hasClass('post-type-archive-agent') ) {
        var agentBox = jQuery('.agents-archive .agent-data');
            agentImg = jQuery('.agents-archive .agent-roster-photo img'),
            agentBoxHeightArr = [],
            agentImgHeightArr = [];

        agentImg.each(function(index) {
            jQuery(this).css('height', 'initial');
            agentImgHeightArr.push(jQuery(this).outerHeight(true));
        });

        agentBox.each(function(index) {
            agentBoxHeightArr.push(jQuery(this).outerHeight(true));
        });

        console.log(agentImgHeightArr);
        console.log(agentBoxHeightArr);

        minImg = Math.max.apply(null, agentBoxHeightArr);
        maxBox = Math.min.apply(null, agentBoxHeightArr);

        console.log(minImg);
        console.log(maxBox);

        if(minImg >= maxBox) {
            agentBox.each(function(index) {
                agentBox.css('height', minImg * 1.25);
            });
        } else {

        }
    }
}

/**
 * Finds the OS of the user & appends it to the buttons on the CTA door
 * so that I can target them with specific CSS for positioning
 */
function typefill() {
    if ( jQuery('body').hasClass('find-properties') ) {
        var os = navigator.platform,
        text = jQuery('.door-cta-wrapper.no-mobile .door-cta-button');

        jQuery(text).each(function(index) {
            jQuery(this).addClass(os);
        });
    }
}

jQuery(document).ready(function() {
    agentSizer();
    typefill();
});

jQuery(window).resize(function() {
    agentSizer();
});
