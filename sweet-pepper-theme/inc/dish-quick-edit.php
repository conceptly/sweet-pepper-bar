<?php
/**
 * The menu store — size and price in Quick Edit, in the «Блюда» and «Напитки» tables.
 *
 * The price is what the team changes most, and the table is where they look for a
 * dish (team, 20 Sep 2026; the test that chose this store, 23 Sep 2026). «Свойства» under a row opens WordPress's own Quick Edit with
 * the two sizes and prices in it: change, «Обновить», the row redraws — the dish is never
 * opened. Everything else about a dish stays on its own screen.
 *
 * Three parts, the standard pattern:
 *   1. quick_edit_custom_box — the inputs, printed once per table, under the «Выход и цена» column;
 *   2. a few lines of script — Quick Edit only fills WordPress's own fields, so ours are
 *      filled from data-* attributes the column prints (inc/menu-data-dishes.php);
 *   3. save_post_{dish,drink} — nonce, capability, then update_field() by KEY, so the value
 *      lands exactly where the dish's own screen puts it.
 *
 * @package Sweet_Pepper
 */

/** Quick Edit field → [ SCF field key, kind ]. */
function sweet_pepper_dish_quick_fields() {
    return [
        'amount'   => [ 'field_sp_dish_dish_amount', 'number' ],
        'unit'     => [ 'field_sp_dish_dish_unit', 'unit' ],
        'price'    => [ 'field_sp_dish_dish_price', 'number' ],
        'amount_2' => [ 'field_sp_dish_dish_amount_2', 'number' ],
        'unit_2'   => [ 'field_sp_dish_dish_unit_2', 'unit' ],
        'price_2'  => [ 'field_sp_dish_dish_price_2', 'number' ],
    ];
}

/** The units a dish can carry — read from the field itself, so the two lists can't drift. */
function sweet_pepper_dish_quick_units() {
    $field = function_exists( 'acf_get_field' ) ? acf_get_field( 'field_sp_dish_dish_unit' ) : null;
    return ( $field && ! empty( $field['choices'] ) ) ? $field['choices'] : [ 'g' => 'г', 'ml' => 'мл', 'l' => 'л', 'pcs' => 'шт' ];
}

/**
 * The values Quick Edit starts from, as data-* attributes. Called by the «Выход и цена»
 * column (inc/menu-data-dishes.php → sweet_pepper_dish_admin_column()).
 */
function sweet_pepper_dish_quick_data( $post_id ) {
    $attrs = '';
    foreach ( sweet_pepper_dish_quick_fields() as $name => $def ) {
        $attrs .= sprintf( ' data-%s="%s"', esc_attr( $name ), esc_attr( (string) get_field( $name, $post_id ) ) );
    }
    return '<span class="sp-dish-quick" hidden' . $attrs . '></span>';
}

function sweet_pepper_dish_quick_edit_box( $column, $post_type ) {
    if ( ! in_array( $post_type, sweet_pepper_menu_item_types(), true ) || 'sp_sizes' !== $column ) {
        return;
    }
    $units = sweet_pepper_dish_quick_units();
    $size  = function ( $suffix, $legend ) use ( $units ) {
        ?>
        <div class="sp-dish-quick__size">
            <span class="title"><?php echo esc_html( $legend ); ?></span>
            <label><span class="screen-reader-text">Выход</span>
                <input type="number" min="0" step="any" name="sp_dish_amount<?php echo esc_attr( $suffix ); ?>" placeholder="выход"></label>
            <label><span class="screen-reader-text">Единица</span>
                <select name="sp_dish_unit<?php echo esc_attr( $suffix ); ?>">
                    <?php foreach ( $units as $value => $label ) : ?>
                        <option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
                    <?php endforeach; ?>
                </select></label>
            <label><span class="screen-reader-text">Цена</span>
                <input type="number" min="0" step="1" name="sp_dish_price<?php echo esc_attr( $suffix ); ?>" placeholder="цена"> -.</label>
        </div>
        <?php
    };
    ?>
    <fieldset class="inline-edit-col-right sp-dish-quick__box">
        <div class="inline-edit-col">
            <?php wp_nonce_field( 'sp_dish_quick_edit', 'sp_dish_quick_nonce', false ); ?>
            <?php $size( '', 'Выход и цена' ); ?>
            <?php $size( '_2', 'Второй размер' ); ?>
            <p class="description">Второй размер — для напитков (40 мл / 500 мл). Чтобы убрать его с сайта, очистите и выход, и цену.</p>
        </div>
    </fieldset>
    <?php
}
add_action( 'quick_edit_custom_box', 'sweet_pepper_dish_quick_edit_box', 10, 2 );

function sweet_pepper_dish_quick_edit_save( $post_id ) {
    if ( ! isset( $_POST['sp_dish_quick_nonce'] ) ) {
        return; // the dish's own screen, the seeder, a REST save — not Quick Edit
    }
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sp_dish_quick_nonce'] ) ), 'sp_dish_quick_edit' ) ) {
        return;
    }
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    if ( ! function_exists( 'update_field' ) ) {
        return;
    }

    $units = sweet_pepper_dish_quick_units();
    foreach ( sweet_pepper_dish_quick_fields() as $name => $def ) {
        if ( ! isset( $_POST[ 'sp_dish_' . $name ] ) ) {
            continue;
        }
        $raw = trim( sanitize_text_field( wp_unslash( $_POST[ 'sp_dish_' . $name ] ) ) );
        if ( 'unit' === $def[1] ) {
            $value = isset( $units[ $raw ] ) ? $raw : 'g';
        } else {
            $raw   = str_replace( ',', '.', $raw ); // 0,5 л
            $value = ( '' === $raw || ! is_numeric( $raw ) ) ? '' : max( 0, $raw + 0 );
        }
        update_field( $def[0], $value, $post_id );
    }
}
add_action( 'save_post_dish', 'sweet_pepper_dish_quick_edit_save' );
add_action( 'save_post_drink', 'sweet_pepper_dish_quick_edit_save' );

/** Fill our inputs when a row's Quick Edit opens; tidy the box. Dishes and Drinks tables only. */
function sweet_pepper_dish_quick_edit_script() {
    $screen = get_current_screen();
    if ( ! $screen || ! in_array( $screen->id, [ 'edit-dish', 'edit-drink' ], true ) ) {
        return;
    }
    ?>
    <style>
        .sp-dish-quick__size { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
        .sp-dish-quick__size .title { width: 9em; }
        .sp-dish-quick__size input[type="number"] { width: 7em; }
    </style>
    <script>
    jQuery( function ( $ ) {
        if ( typeof inlineEditPost === 'undefined' ) { return; }
        var open = inlineEditPost.edit;
        inlineEditPost.edit = function ( id ) {
            open.apply( this, arguments );
            var postId = typeof id === 'object' ? parseInt( this.getId( id ), 10 ) : id;
            var data = $( '#post-' + postId ).find( '.sp-dish-quick' );
            var box = $( '#edit-' + postId );
            <?php echo wp_json_encode( array_keys( sweet_pepper_dish_quick_fields() ) ); ?>.forEach( function ( name ) {
                var value = data.attr( 'data-' + name );
                if ( /^unit/.test( name ) && ! value ) { value = 'g'; }
                box.find( '[name="sp_dish_' + name + '"]' ).val( value || '' );
            } );
        };
    } );
    </script>
    <?php
}
add_action( 'admin_footer-edit.php', 'sweet_pepper_dish_quick_edit_script' );
