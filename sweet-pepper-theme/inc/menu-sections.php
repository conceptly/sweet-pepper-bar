<?php
/**
 * Menu sections — the single source for the section word lists.
 *
 * Read by the hero nav (menu-hero.php), the jump-nav panel (menu-jump-nav.php)
 * and the mobile section rail (menu-section-rail.php), so the nine food words and
 * the seven bar words are typed once. Copy from menu-hero-copy.md (the Figma
 * `menuFood` / `menuBar` variables plus the author's refinements, Sep 2026):
 *   label       — nav word (website-brief.md → Menu page → Section labels)
 *   cta_label   — the phone hero's commit button (Figma ctaLabel)
 *   icon        — its glyph: assets/icons/c-<icon>.svg (Figma Icon, currentColor twins)
 *   caption     — photo caption label (Figma imgCaption); must match the photo
 *   description — hero paragraph (Figma DescriptionHero)
 * nav_variant drives the hero's colour rule (default = alcoholic → Chili active; non-alco → Lime).
 *
 * @package Sweet_Pepper
 */

/**
 * @param string $state 'food' | 'drinks'
 * @return array slug => [ label, image, caption, description, nav_variant ]
 */
function sweet_pepper_menu_sections( $state = 'food' ) {
    // 'focus' — the hero photo's focal point (CSS object-position). Only the tablet band crops
    // the 3:2 photo (to 21:9, menu-hero.css), keeping 64% of its height, so the value says
    // which 64%: '50% 30%' keeps the top, '50% 70%' the bottom. Chosen per photo, Sep 2026.
    // ── Food sections ──
    // Copy from menu-hero-copy.md
    $food_sections = [
        'breakfast'   => [
            'label'       => 'Breakfast',
            'cta_label'   => 'Breakfast',
            'icon'        => 'coffee',
            'image'       => 'food/breakfast/pepper-breakfast-2.jpg',
            'focus'       => '50% 60%',
            'caption'     => "Pepper's breakfast",
            'description' => "Breakfast doesn't end here — some mornings start at noon, we understand. Same price whenever yours begins, and a glass of bubbles for next to nothing.",
            'nav_variant' => 'non-alco',
        ],
        'lunch'       => [
            'label'       => 'Lunch',
            'cta_label'   => 'Lunch',
            'icon'        => 'food',
            'image'       => 'food/lunch/bagel-lunch-1.jpg',
            'focus'       => '50% 50%',
            'caption'     => 'Bagel lunch set',
            'description' => "Weekday lunch, 12 to 4 — salad, soup, a hot dish and a drink. In and out in thirty minutes if you must; no rush if you needn't.",
            'nav_variant' => 'non-alco',
        ],
        'bar-snacks'  => [
            'label'       => 'Bar Snacks',
            'cta_label'   => 'Bar Snacks',
            'icon'        => 'cocktail',
            'image'       => 'food/snacks/meat-set-2.jpg',
            'focus'       => '50% 50%',
            'caption'     => 'Meat set 2026',
            'description' => "Built to be the best pair — boards, pickles, wings, and things that hold a drink's hand. The bar has opinions about which drink; ask.",
            'nav_variant' => 'non-alco',
        ],
        'salads'      => [
            'label'       => 'Salads',
            'cta_label'   => 'Salads',
            'icon'        => 'food',
            'image'       => 'food/lunch/cobb-1.jpg',
            'focus'       => '50% 50%',
            'caption'     => 'The iconic Cobb',
            'description' => "Big, honest salads — a proper Cobb, a Sicilian with oranges, three Caesars deep. The vegetarian ones aren't an apology.",
            'nav_variant' => 'non-alco',
        ],
        'sandwiches'  => [
            'label'       => 'Sandwiches',
            'cta_label'   => 'Sandwiches & Bagels',
            'icon'        => 'burger',
            'image'       => 'food/lunch/sweet-130.jpg',
            'focus'       => '50% 35%',
            'caption'     => "Pepper's chicken club",
            'description' => "Bagels and sandwiches stacked like we mean it — lunch that fits in one hand, built in a kitchen that takes both seriously.",
            'nav_variant' => 'non-alco',
        ],
        'soups'       => [
            'label'       => 'Soups',
            'cta_label'   => 'Soups',
            'icon'        => 'soup',
            'image'       => 'food/lunch/pumpkin.png',
            'focus'       => '50% 30%',
            'caption'     => 'Iconic Pumpkin soup',
            'description' => "Signature borscht with salo croutons, pumpkin cream, a mushroom mug — the first course is not negotiable around here.",
            'nav_variant' => 'non-alco',
        ],
        'hot-dishes'  => [
            'label'       => 'Hot Dishes',
            'cta_label'   => 'Hot Dishes',
            'icon'        => 'wine',
            'image'       => 'food/dinner/zharkoe-1.jpg',
            'focus'       => '50% 45%',
            'caption'     => 'Yaroslavl-style roast',
            'description' => "Pastas, steaks, the grill, and the roast — the serious half of the kitchen, running all day, garnishes included.",
            'nav_variant' => 'non-alco',
        ],
        'desserts'    => [
            'label'       => 'Desserts',
            'cta_label'   => 'Desserts',
            'icon'        => 'coffee',
            'image'       => 'food/dessert/napoleon-1.jpg',
            'focus'       => '50% 40%',
            'caption'     => 'Raspberry Mille-feuille',
            'description' => "Apple strudel with ice cream, raspberry Napoleon, three cheesecakes to choose between. Save room — or don't, and take one home.",
            'nav_variant' => 'non-alco',
        ],
        'kids'        => [
            'label'       => 'Kids',
            'cta_label'   => 'For Kids',
            'icon'        => 'food',
            'image'       => 'food/kids/kids-nuggets-2.jpg',
            'focus'       => '50% 70%',
            'caption'     => 'Home-made nuggets',
            'description' => "For guests under 14 — real food from the same kitchen, smaller plates, kinder prices. Crayons live behind the bar; just ask.",
            'nav_variant' => 'non-alco',
        ],
    ];

    // ── Bar sections ──
    // Copy from menu-hero-copy.md; images use best available match from bar/ folder
    $bar_sections = [
        'infusions'    => [
            'label'       => 'Infusions',
            'cta_label'   => 'Homemade Infusions',
            'icon'        => 'cocktail',
            'image'       => 'bar/infusions/infusions-lenya-11.jpg',
            'focus'       => '50% 40%',
            'caption'     => 'Berry festival',
            'description' => "Made in-house since 2014 — cranberry to salted caramel to raspberry gin. Start with one; the 3+1 deal knows you won't stop there.",
            'nav_variant' => 'default',
        ],
        'cocktails'    => [
            'label'       => 'Cocktails',
            'cta_label'   => 'Cocktails',
            'icon'        => 'cocktail',
            'image'       => 'bar/cocktails/manhattan-3-2.jpg',
            'focus'       => '50% 40%',
            'caption'     => 'Manhattan',
            'description' => "Classics poured straight and twists poured loud — plus a new one on the board every week. Shaken ten steps from your dinner.",
            'nav_variant' => 'default',
        ],
        'wine'         => [
            'label'       => 'Wine',
            'cta_label'   => 'Wine',
            'icon'        => 'wine',
            'image'       => 'bar/wine/red-2.jpg',
            'focus'       => '50% 50%',
            'caption'     => "Tonight's red",
            'description' => "By the glass or by the bottle, with sherry and vermouth keeping company. Wednesdays the open bottles go 10% off — the loud corner of the quiet list.",
            'nav_variant' => 'default',
        ],
        'beer'         => [
            'label'       => 'Beer',
            'cta_label'   => 'Beer',
            'icon'        => 'beer',
            'image'       => 'bar/beer/beer-05.jpg',
            'focus'       => '50% 60%',
            'caption'     => 'Ring for a beer',
            'description' => "Bottled and on tap, cold enough to settle arguments. There's a bell on the counter that says \"ring for a beer\" — it works.",
            'nav_variant' => 'default',
        ],
        'spirits'      => [
            'label'       => 'Spirits',
            'cta_label'   => 'Spirits',
            'icon'        => 'cocktail',
            'image'       => 'bar/hard-drinks/jim-beam-1.jpg',
            'focus'       => '50% 50%',
            'caption'     => 'The bourbon shelf',
            'description' => "Whisky by country, tequila, gin and their friends — 40 ml of whatever the evening calls for. The back bar is deeper than it looks.",
            'nav_variant' => 'default',
        ],
        'no-buzz'      => [
            'label'       => 'No Buzz',
            'cta_label'   => 'No Buzz',
            'icon'        => 'glass',
            'image'       => 'bar/cocktails-non-alco/smoothie-1.jpg',
            'focus'       => '50% 55%',
            'caption'     => 'Berry smoothie',
            'description' => "Smoothies, virgin cocktails, lemonades, milkshakes — full bar swagger, none of the proof. Designated drivers drink like kings here.",
            'nav_variant' => 'non-alco',
        ],
        'tea-coffee'   => [
            'label'       => 'Tea & Coffee',
            'cta_label'   => 'Tea & Coffee',
            'icon'        => 'coffee',
            'image'       => 'bar/coffee/cappuccino-icecream-1.jpg',
            'focus'       => '50% 50%',
            'caption'     => "Iconic Pepper's Cappuccino",
            'description' => "Espresso to signature teas, first light till last call — the bar's other shift. Anything to go is 10% off, mornings included.",
            'nav_variant' => 'non-alco',
        ],
    ];

    return ( $state === 'drinks' ) ? $bar_sections : $food_sections;
}

/**
 * Which menu state a section slug belongs to.
 *
 * @return string 'food' | 'drinks'
 */
function sweet_pepper_menu_state_for( $slug ) {
    return array_key_exists( $slug, sweet_pepper_menu_sections( 'drinks' ) ) ? 'drinks' : 'food';
}

/**
 * A food-menu connector in Russian: the English file stem → its RU twin in
 * assets/sectionLinks/menu/kitchen-{day,night}/ru/ and the words for its alt
 * (menu-copy-ru-draft.md → «Коннекторы кухни», the author's Figma exports of 23 Sep 2026).
 * The hero's FOOD MENU is not here yet: its RU export is filled, not outlined, and has
 * no night file or reflection — it stays English until re-exported.
 */
function sweet_pepper_menu_connectors_ru() {
    return [
        'getItWhileItLasts' => [ 'толькоЭтойОсенью', 'Только этой осенью' ],
        'yummyMorning'      => [ 'начатьДеньСоВкусом', 'Начать день со вкусом' ],
        'theBestInTheCity'  => [ 'лучшиеОбедыВГороде', 'Лучшие обеды в городе' ],
        'fingerLickingFood' => [ 'делитьсяНеОбязательно', 'Делиться не обязательно' ],
        'freshAsItGets'     => [ 'классикаИХитыОтПерцев', 'Классика и хиты от Перцев' ],
        'stackedWithLove'   => [ 'лучшиеБубликиВГороде', 'Лучшие бублики в городе' ],
        'spoonTherapy'      => [ 'восторгВКаждойЛожке', 'Восторг в каждой ложке' ],
        'comfortFood'       => [ 'сытноВкусноУютно', 'Сытно, вкусно, уютно' ],
        'sweetLikePepper'   => [ 'даёшьСладкуюЖизнь', 'Даёшь сладкую жизнь!' ],
        'tryTheMatchMaker'  => [ 'параОтБараВместеВкуснее', 'Пара от бара — вместе вкуснее' ],
        'youllLikeIt'       => [ 'вамЗдесьПонравится', 'Вам здесь понравится' ],
    ];
}

/**
 * Swap a connector's day / night files and alt for the Russian twins — on a Russian
 * request of the food menu only (the drinks page reuses two kitchen files; its RU
 * connectors are still undecided — menu-copy-ru-draft.md → «Коннекторы бара»).
 * Called by template-parts/components/section-link-word.php. Both files must exist,
 * or the English pair stays: a word never shows one language by day and another by night.
 *
 * @return array [ day path, night path, alt ]
 */
function sweet_pepper_menu_connector_lang( $day, $night, $alt ) {
    if ( 'ru' !== sweet_pepper_lang() || ( isset( $_GET['menu'] ) && 'drinks' === $_GET['menu'] ) ) {
        return [ $day, $night, $alt ];
    }
    $pattern = '~^assets/sectionLinks/menu/(?:kitchen-day|kitchen-night|bar)/([A-Za-z]+?)(-reflection)?\.svg$~';
    if ( ! preg_match( $pattern, (string) $day, $d ) || ! preg_match( $pattern, (string) $night, $n ) || $d[1] !== $n[1] ) {
        return [ $day, $night, $alt ];
    }
    $twin = sweet_pepper_menu_connectors_ru()[ $d[1] ] ?? null;
    if ( ! $twin ) {
        return [ $day, $night, $alt ];
    }
    $ru = [];
    foreach ( [ 'day' => $d, 'night' => $n ] as $mode => $m ) {
        $ru[ $mode ] = "assets/sectionLinks/menu/kitchen-{$mode}/ru/{$twin[0]}" . ( $m[2] ?? '' ) . '.svg';
        if ( ! file_exists( get_template_directory() . '/' . $ru[ $mode ] ) ) {
            return [ $day, $night, $alt ];
        }
    }
    return [ $ru['day'], $ru['night'], $twin[1] ];
}
