<?php
use \hji\AgentRoster\AgentRoster;

// Grab all agent names for search field
$name_query = new WP_Query( array( 'post_type' => array( 'agent' ), 'posts_per_page' => -1 ) );
$names = '<option></option>';

while ( $name_query->have_posts() ) : $name_query->the_post();
    $names .= '<option>';
        $names .= get_the_title();
    $names .= '</option>';
endwhile;

wp_reset_query();

// Top producer tag slug (lookup parameter)
$topProducerSlug = 'top-producer';

// Number of Columns in a Grid
$columns = 3; // 2 & 3 supported only

// Pre-set our default filter with specific sorting
$default_tax_query = array( // do not include top producers
    array(
        'taxonomy' => AgentRoster::AGENTS_TAXONOMY,
        'field' => 'slug',
        'operator' => (get_query_var(AgentRoster::AGENTS_TAXONOMY)) ? 'IN' : 'NOT IN',
        'terms' => (get_query_var(AgentRoster::AGENTS_TAXONOMY)) ? get_query_var(AgentRoster::AGENTS_TAXONOMY) : $topProducerSlug,
    )
);
$default_params = array(
    'post_type'     => 'agent',
    'meta_key'      => '_cmb_last_name',
    'orderby'       => 'meta_value',
    'meta_query'    => array(
        array(
            'key' => '_cmb_first_name',
        )
    ),
    'tax_query'     => $default_tax_query,
    'order'         => 'ASC',
    'posts_per_page'=> -1,
);
// Parameters container to customize WP Query
$params = array();
// Embedded Team - global var with custom wp_query - returns null if not set
global $team_query;

// If Embedded Team was not requested - render header with alphabet and search filters
if ( $team_query == false ) {
    // Template header
    echo '<section class="agents-archive">';
    echo '<article>';

    // BEGIN Search Agent form
    $agent_search_form = <<<FORM
        <form role="search" method="get" id="agent-search-form">
            <div class="input-group">
                <select type="text" name="s" id="s" placeholder="Enter agent's name ..." class="agent-search">
                    "$names"
                </select>
                <span class="input-group-btn">
                    <input type="submit" id="searchsubmit" class="btn btn-primary" value="Find Agent" />
                </span>
            </div>
            <input type="hidden" name="property_type" value="agent" />
        </form>
FORM;
    // END Search Agent

    // Check if office ID was passed
    if ( isset( $_GET['office_id'] ) ) {
        $office_name = get_post_meta( $_GET['office_id'], '_cmb_office_name', true );

        echo '<header class="header">';
        echo '<h1 class="entry-title">Agents in ' . $office_name . ' Office</h1>';
        echo '</header>';

        $params['meta_query'] = array(
            array(
                'key' => '_cmb_office_id',
                'value' => $_GET['office_id'],
            )
        );

        echo '<section class="entry-content">';
        echo '<div id="agent-roster-filters">';
        echo $agent_search_form;
        echo '</div>';
    } else {
        echo '<header class="page-header">';
        echo '<h1 class="page-title">Agent Roster</h1>';
        echo '</header>';
        echo '<section class="entry-content">';

        // this is the custom copy that is at the top of the page
        get_template_part( 'templates/partials/agent-page-custom-copy' );
        echo '<div id="agent-roster-filters">';

        // BEGIN Agent Index (alphabet)
        $taxonomy = 'agent_index';

        // Save the terms that have posts in an array as a transient
        if ( false === ( $alphabet = get_transient('archive_alphabet') ) ) {

            // It wasn't there, so regenerate the data and save the transient
            $terms = get_terms($taxonomy);
            $alphabet = array();
            if ($terms) {
                foreach ($terms as $term) {
                    $alphabet[] = $term->slug;
                }
            }

            set_transient( 'archive_alphabet', $alphabet );
        }
        ?>

        <div id="archive-menu" class="row">
            <?php echo $agent_search_form; ?>
            <ul id="agent-index">
                <li class="menu-item"><a href="<?php echo get_post_type_archive_link( 'agent' ); ?>">All</a></li>
                <?php
                foreach ( range('a', 'z') as $i ) {
                    $current = ( $i == get_query_var($taxonomy) ) ? "current-menu-item" : "menu-item";
                    if ( in_array($i, $alphabet) ) {
                        printf( '<li class="az-char %s"><a href="%s">%s</a></li>', $current, get_term_link($i, $taxonomy), strtoupper($i) );
                    } else {
                        printf( '<li class="az-char %s disabled"><a href="javascript: void(0)">%s</a></li>', $current, strtoupper($i) );
                    }
                }
                ?>
            </ul>
        </div>

        <?php
        echo '</div>'; // #agent-roster-filters
    }

    // END Agent Index

    // Check if agent search was initiated
    if ($search = get_search_query()) {
        $params['s'] = $search;
    } else {
        // Check if alphabet filter was initiated
        $agent_index = false;
        if ( isset($wp_query->query_vars['agent_index']) && !empty($wp_query->query_vars['agent_index']) ) {
            $agent_index = $wp_query->query_vars['agent_index'];
        }
        $params['agent_index'] = $agent_index;
    }

    // END check team_query

    $params = array_merge($default_params, $params);

    // Top Producers loop
    if ( (is_tax('agent_index') || !is_tax()) && isset($topProducerSlug) && ($team_query == false) ) {
        $topProducerParams = array(
            'tax_query' => array(
                array(
                    'taxonomy'  => AgentRoster::AGENTS_TAXONOMY,
                    'field'     => 'slug',
                    'terms'     => $topProducerSlug,
                    'operator'  => 'IN',
                )
            ),
            'posts_per_page' => -1,
        );
        $topProducerParams = array_merge($params, $topProducerParams);
        $query = new \WP_Query($topProducerParams);

        echo '<div class="top-producers">';
        include AGRO_PATH . 'templates/agents-loop.php';
        echo '</div>';
    }

    // Standard posts loop - render content
    if ( $team_query == false ) {
        if ( is_tax() && !is_tax('agent_index') ) {
            // Regular taxonomy query
            $query = new \WP_Query($default_params);
        } else {
            // Query with possible index search or string search
            $query = new \WP_Query($params);
        }
    } else {
        $query = $team_query;
    }

    include AGRO_PATH . 'templates/agents-loop.php';

    if ( $team_query == false ) {
        echo '</article>';

        // this is the custom agent office info.
        get_template_part( 'templates/partials/agent-page-custom-office-info' );

        echo '</section>'; // class agents-archive
    }
}
