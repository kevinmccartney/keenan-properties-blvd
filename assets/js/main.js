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
            agentImgHeightArr.push(jQuery(this).outerHeight(true));
        });

        agentBox.each(function(index) {
            jQuery(this).css('height', 'initial');
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

/**
 * Appends a small string indicating that the excerpt continues to all 
 * post excerpts in an archive
 */
function blogBeautifier() {
    if( jQuery('body').hasClass('archive') ) {
        var archiveEntryButton = jQuery('article.type-post .entry-content .read-more-link');

        jQuery(archiveEntryButton).each(function(index) {
            jQuery(this).before(' [...]');
        });
    }
}

jQuery(document).ready(function() {
    agentSizer();
    typefill();
    blogBeautifier();
});

jQuery(window).resize(function() {
    agentSizer();
});
