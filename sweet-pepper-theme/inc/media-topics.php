<?php
/**
 * Media topics — «Темы» on images, the Media Library's folders without a plugin
 * (website-brief.md → Platform → *Media topics*; author, 23 Sep 2026).
 *
 * WordPress keeps every upload in one flat library. A topic is a label, not a folder:
 * the file stays where WordPress put it, an image can carry two topics, and a wrong
 * one breaks nothing. Four parts:
 *   1. the taxonomy on attachments, with the default topics made on first admin load;
 *   2. checkboxes in the image's details (the Library's panel and every picker);
 *   3. a «Тема» filter — list view (a dropdown) and grid view / pickers (a media-views filter);
 *   4. bulk actions in list view: «Тема: Еда» … on the ticked images.
 * tools/media-topics.php labels unlabelled images by where the site uses them.
 *
 * @package Sweet_Pepper
 */

/** The topics the library starts with: slug => name. More can be added in Media → Темы. */
function sweet_pepper_media_topic_defaults() {
    return [
        'food'     => 'Еда',
        'bar'      => 'Бар',
        'team'     => 'Команда',
        'guests'   => 'Гости',
        'events'   => 'События',
        'interior' => 'Интерьер',
        'brand'    => 'Логотип и бренд',
    ];
}

function sweet_pepper_register_media_topics() {
    register_taxonomy( 'media_topic', 'attachment', [
        'labels'            => [
            'name'          => 'Темы',
            'singular_name' => 'Тема',
            'menu_name'     => 'Темы',
            'all_items'     => 'Все темы',
            'edit_item'     => 'Тема',
            'add_new_item'  => 'Новая тема',
            'search_items'  => 'Найти тему',
            'not_found'     => 'Тем нет',
        ],
        'public'            => false,
        'show_ui'           => true,  // Media → Темы: rename or add a topic
        'show_in_menu'      => true,
        'show_admin_column' => true,  // the list view's «Темы» column
        'show_in_rest'      => false,
        'hierarchical'      => true,  // checkboxes, not a free-text tag box
        'query_var'         => 'media_topic', // the filters and the picker's AJAX query use it
        'rewrite'           => false,
        'update_count_callback' => '_update_generic_term_count', // attachments are 'inherit', not 'publish'
    ] );
}
add_action( 'init', 'sweet_pepper_register_media_topics' );

/** The default topics exist on every install (Local, the test site) without a seeding step. */
function sweet_pepper_media_topics_ensure() {
    if ( get_option( 'sp_media_topics_seeded' ) ) {
        return;
    }
    foreach ( sweet_pepper_media_topic_defaults() as $slug => $name ) {
        if ( ! term_exists( $slug, 'media_topic' ) ) {
            wp_insert_term( $name, 'media_topic', [ 'slug' => $slug ] );
        }
    }
    update_option( 'sp_media_topics_seeded', 1, false ); // once: a topic the team deletes stays deleted
}
add_action( 'admin_init', 'sweet_pepper_media_topics_ensure' );

/** All topics, in the order the defaults list them, then any the team added (A–Я). */
function sweet_pepper_media_topics() {
    $terms = get_terms( [ 'taxonomy' => 'media_topic', 'hide_empty' => false ] );
    if ( is_wp_error( $terms ) ) {
        return [];
    }
    $order = array_flip( array_keys( sweet_pepper_media_topic_defaults() ) );
    usort( $terms, fn( $a, $b ) => [ $order[ $a->slug ] ?? 99, $a->name ] <=> [ $order[ $b->slug ] ?? 99, $b->name ] );
    return $terms;
}

/**
 * 2. Checkboxes in an image's details. WordPress would print the taxonomy there as a text
 * box of comma-separated slugs; ours replaces it. The Library's panel saves each tick at once.
 */
function sweet_pepper_media_topic_field( $fields, $post ) {
    unset( $fields['media_topic'] );
    $topics = sweet_pepper_media_topics();
    if ( ! $topics ) {
        return $fields;
    }
    $mine = wp_get_object_terms( $post->ID, 'media_topic', [ 'fields' => 'ids' ] );
    $html = '<input type="hidden" name="attachments[' . (int) $post->ID . '][sp_topics_sent]" value="1">';
    foreach ( $topics as $term ) {
        $html .= sprintf(
            '<label style="display:inline-block;margin:0 12px 4px 0"><input type="checkbox" name="attachments[%d][sp_topics][]" value="%d"%s> %s</label>',
            (int) $post->ID, (int) $term->term_id, checked( in_array( $term->term_id, $mine, true ), true, false ), esc_html( $term->name )
        );
    }
    $fields['sp_topics'] = [ 'label' => 'Тема', 'input' => 'html', 'html' => $html ];
    return $fields;
}
add_filter( 'attachment_fields_to_edit', 'sweet_pepper_media_topic_field', 10, 2 );

function sweet_pepper_media_topic_save( $post, $attachment ) {
    if ( empty( $attachment['sp_topics_sent'] ) || ! current_user_can( 'edit_post', $post['ID'] ) ) {
        return $post;
    }
    $ids = array_map( 'intval', (array) ( $attachment['sp_topics'] ?? [] ) );
    wp_set_object_terms( $post['ID'], $ids, 'media_topic' );
    return $post;
}
add_filter( 'attachment_fields_to_save', 'sweet_pepper_media_topic_save', 10, 2 );

/** 3a. List view: a «Все темы» dropdown beside «All dates». */
function sweet_pepper_media_topic_list_filter( $post_type ) {
    if ( 'attachment' !== $post_type ) {
        return;
    }
    $current = isset( $_GET['media_topic'] ) ? sanitize_key( $_GET['media_topic'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification -- a list filter
    echo '<label class="screen-reader-text" for="sp-media-topic">Тема</label><select name="media_topic" id="sp-media-topic"><option value="">Все темы</option>';
    foreach ( sweet_pepper_media_topics() as $term ) {
        printf( '<option value="%s"%s>%s (%d)</option>', esc_attr( $term->slug ), selected( $current, $term->slug, false ), esc_html( $term->name ), (int) $term->count );
    }
    echo '</select>';
}
add_action( 'restrict_manage_posts', 'sweet_pepper_media_topic_list_filter' );

/**
 * 3b. Grid view and every image picker: a «Все темы» filter in the media toolbar. WordPress
 * passes the taxonomy's query var through its attachment query, so this is display only.
 */
function sweet_pepper_media_topic_grid_filter() {
    $topics = array_map( fn( $t ) => [ 'slug' => $t->slug, 'name' => $t->name ], sweet_pepper_media_topics() );
    if ( ! $topics ) {
        return;
    }
    $script = 'window.spMediaTopics = ' . wp_json_encode( $topics ) . ';' . <<<'JS'
( function () {
    var media = window.wp && wp.media;
    if ( ! media || ! media.view || ! media.view.AttachmentFilters ) { return; }
    var TopicFilter = media.view.AttachmentFilters.extend( {
        id: 'sp-media-topic-filter',
        createFilters: function () {
            var filters = { all: { text: 'Все темы', props: { media_topic: '' }, priority: 1 } };
            window.spMediaTopics.forEach( function ( t, i ) {
                filters[ t.slug ] = { text: t.name, props: { media_topic: t.slug }, priority: i + 2 };
            } );
            this.filters = filters;
        }
    } );
    var Browser = media.view.AttachmentsBrowser;
    media.view.AttachmentsBrowser = Browser.extend( {
        createToolbar: function () {
            Browser.prototype.createToolbar.apply( this, arguments );
            this.toolbar.set( 'spMediaTopic', new TopicFilter( {
                controller: this.controller,
                model: this.collection.props,
                priority: -75
            } ).render() );
        }
    } );
} )();
JS;
    wp_add_inline_script( 'media-views', $script );
}
add_action( 'wp_enqueue_media', 'sweet_pepper_media_topic_grid_filter' );

/** 4. List view bulk actions: tick images, choose «Тема: Еда», Apply — the topic is added. */
function sweet_pepper_media_topic_bulk_actions( $actions ) {
    foreach ( sweet_pepper_media_topics() as $term ) {
        $actions[ 'sp_topic_' . $term->slug ] = 'Тема: ' . $term->name;
    }
    $actions['sp_topic_none'] = 'Тема: снять все';
    return $actions;
}
add_filter( 'bulk_actions-upload', 'sweet_pepper_media_topic_bulk_actions' );

function sweet_pepper_media_topic_bulk_apply( $redirect, $action, $ids ) {
    if ( 0 !== strpos( $action, 'sp_topic_' ) ) {
        return $redirect;
    }
    $slug = substr( $action, strlen( 'sp_topic_' ) );
    foreach ( $ids as $id ) {
        if ( ! current_user_can( 'edit_post', $id ) ) {
            continue;
        }
        if ( 'none' === $slug ) {
            wp_set_object_terms( $id, [], 'media_topic' );
        } else {
            wp_set_object_terms( $id, $slug, 'media_topic', true ); // added, not replaced
        }
    }
    return $redirect;
}
add_filter( 'handle_bulk_actions-upload', 'sweet_pepper_media_topic_bulk_apply', 10, 3 );
