/**
 * Finds the OS of the user & appends it to the buttons on the CTA door
 * so that I can target them with specific CSS for positioning
 */
function osFill() {
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
    osFill();
    blogBeautifier();
});
