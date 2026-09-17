<?php
/**
 * Menu Section — Spirits
 *
 * @package Sweet_Pepper
 */
?>

<section id="spirits" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/hard-drinks/jim-beam-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Jim Beam White Label' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Jim Beam White Label' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'neat or on the rocks' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'spirits' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: scotch whisky -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'scotch whisky' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Johnnie Walker Red Label',
                            'price'       => '285-.',
                            'quantity'    => '40 ml',
                            'description' => 'Blended Scotch.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'James Crees',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Smooth blended Scotch.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Ballantines Finest',
                            'price'       => '325-.',
                            'quantity'    => '40 ml',
                            'description' => 'Classic blended Scotch.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Aber Falls Madeira Cask',
                            'price'       => '325-.',
                            'quantity'    => '40 ml',
                            'description' => 'Welsh, Madeira cask finish.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Harran 8',
                            'price'       => '475-.',
                            'quantity'    => '40 ml',
                            'description' => '8-year aged single malt.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Loch Lomond',
                            'price'       => '595-.',
                            'quantity'    => '40 ml',
                            'description' => 'Highland single malt.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Laphroaig',
                            'price'       => '675-.',
                            'quantity'    => '40 ml',
                            'description' => 'Islay single malt, peated.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Glenmorangie',
                            'price'       => '675-.',
                            'quantity'    => '40 ml',
                            'description' => 'Highland single malt.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: american whisky -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'american whisky' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Jim Beam White Label',
                            'price'       => '345-.',
                            'quantity'    => '40 ml',
                            'description' => 'Kentucky bourbon classic.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Jack Daniels',
                            'price'       => '365-.',
                            'quantity'    => '40 ml',
                            'description' => 'Tennessee whiskey.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Makers Mark',
                            'price'       => '375-.',
                            'quantity'    => '40 ml',
                            'description' => 'Wheated bourbon.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Wild Turkey 81',
                            'price'       => '485-.',
                            'quantity'    => '40 ml',
                            'description' => 'High-proof bourbon.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: irish whiskey -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'irish whiskey' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'The Pogues',
                            'price'       => '305-.',
                            'quantity'    => '40 ml',
                            'description' => 'Triple-distilled blend.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Samuel Gelstons Pot Still',
                            'price'       => '305-.',
                            'quantity'    => '40 ml',
                            'description' => 'Pot still, complex.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Hinch Distillers Cut',
                            'price'       => '305-.',
                            'quantity'    => '40 ml',
                            'description' => 'Smooth, easy-drinking.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Proper Twelve',
                            'price'       => '425-.',
                            'quantity'    => '40 ml',
                            'description' => 'Smooth Irish blend.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Hinch Peated',
                            'price'       => '585-.',
                            'quantity'    => '40 ml',
                            'description' => 'Peated Irish, smoky.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: world whisky -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'world whisky' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Nestville',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Slovakian single malt.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bankhall Sweet Mash',
                            'price'       => '325-.',
                            'quantity'    => '40 ml',
                            'description' => 'English sweet mash.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bellevoye Grain Fin',
                            'price'       => '495-.',
                            'quantity'    => '40 ml',
                            'description' => 'French triple malt.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: vodka -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'vodka' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Whitley Artisanal Gold',
                            'price'       => '155-.',
                            'quantity'    => '40 ml',
                            'description' => 'Premium artisanal vodka.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Tchaikovsky',
                            'price'       => '190-.',
                            'quantity'    => '40 ml',
                            'description' => 'Classic Russian vodka.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Beluga Noble',
                            'price'       => '230-.',
                            'quantity'    => '40 ml',
                            'description' => 'Siberian noble vodka.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: gin -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'gin' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Whitley Neill Dry',
                            'price'       => '265-.',
                            'quantity'    => '40 ml',
                            'description' => 'London dry gin.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Whitley Neill Rhubarb',
                            'price'       => '265-.',
                            'quantity'    => '40 ml',
                            'description' => 'Rhubarb & ginger gin.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bulldog',
                            'price'       => '315-.',
                            'quantity'    => '40 ml',
                            'description' => 'Bold London dry gin.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Drumshanbo Gunpowder',
                            'price'       => '365-.',
                            'quantity'    => '40 ml',
                            'description' => 'Irish gunpowder gin.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Mare',
                            'price'       => '475-.',
                            'quantity'    => '40 ml',
                            'description' => 'Mediterranean gin.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: rum -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'rum' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Dead Mans Finger Black',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Spiced dark rum.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Nusa Cana Tropical Island',
                            'price'       => '355-.',
                            'quantity'    => '40 ml',
                            'description' => 'Tropical Island rum.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Matusalem Solera 7',
                            'price'       => '395-.',
                            'quantity'    => '40 ml',
                            'description' => 'Dominican solera rum.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Diplomatico Mantuano',
                            'price'       => '395-.',
                            'quantity'    => '40 ml',
                            'description' => 'Venezuelan rum.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Takamaka Extra Noir',
                            'price'       => '395-.',
                            'quantity'    => '40 ml',
                            'description' => 'Seychelles dark rum.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cachaça',
                            'price'       => '325-.',
                            'quantity'    => '40 ml',
                            'description' => 'Brazilian sugarcane spirit.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: cognac & brandy -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'cognac & brandy' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Kizlyar 3★',
                            'price'       => '230-.',
                            'quantity'    => '40 ml',
                            'description' => 'Russian brandy, 3-star.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Ararat 3★',
                            'price'       => '245-.',
                            'quantity'    => '40 ml',
                            'description' => 'Armenian brandy, 3-star.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Vecchia Romagna',
                            'price'       => '285-.',
                            'quantity'    => '40 ml',
                            'description' => 'Italian brandy.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Calvados VSOP',
                            'price'       => '465-.',
                            'quantity'    => '40 ml',
                            'description' => 'Apple brandy, Normandy.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Camus VS',
                            'price'       => '490-.',
                            'quantity'    => '40 ml',
                            'description' => 'French cognac.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Camus VSOP',
                            'price'       => '645-.',
                            'quantity'    => '40 ml',
                            'description' => 'Premium French cognac.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: tequila & mezcal -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'tequila & mezcal' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Dead Mans Fingers Reposado',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Rested tequila.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cuerno de Toro Blanco',
                            'price'       => '355-.',
                            'quantity'    => '40 ml',
                            'description' => 'Unaged, clean tequila.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cuerno de Toro Reposado',
                            'price'       => '375-.',
                            'quantity'    => '40 ml',
                            'description' => 'Rested, smooth tequila.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Pelaton de la Muerte',
                            'price'       => '495-.',
                            'quantity'    => '40 ml',
                            'description' => 'Artisanal mezcal.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: bitter & herbal -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'bitter & herbal' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Aperol Aperitivo',
                            'price'       => '245-.',
                            'quantity'    => '40 ml',
                            'description' => 'Bittersweet orange aperitif.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Jagermeister',
                            'price'       => '285-.',
                            'quantity'    => '40 ml',
                            'description' => 'Herbal digestif.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Martini Riserva Bitter',
                            'price'       => '275-.',
                            'quantity'    => '40 ml',
                            'description' => 'Premium Italian bitter.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cynar Bitter',
                            'price'       => '245-.',
                            'quantity'    => '40 ml',
                            'description' => 'Artichoke-based bitter.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Campari Bitter',
                            'price'       => '265-.',
                            'quantity'    => '40 ml',
                            'description' => 'The iconic Italian red bitter.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Fernet Branca',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Intensely herbal Italian amaro.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Branca Menta',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Minty Fernet variation.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Amaro Montenegro',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Balanced, aromatic Italian amaro.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Absinthe',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Anise-forward classic spirit.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: liqueurs -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'liqueurs' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Sambuca',
                            'price'       => '265-.',
                            'quantity'    => '40 ml',
                            'description' => 'Anise Italian liqueur.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Berkshire Sloe Gin',
                            'price'       => '265-.',
                            'quantity'    => '40 ml',
                            'description' => 'Sloe berry gin liqueur.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bols (assorted)',
                            'price'       => '285-.',
                            'quantity'    => '40 ml',
                            'description' => 'Dutch liqueur, ask for flavours.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Benvenutti Nocino',
                            'price'       => '295-.',
                            'quantity'    => '40 ml',
                            'description' => 'Walnut liqueur, rich and earthy.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: WORLD AND LOCAL HITS -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/worldAndLocalHits.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/worldAndLocalHits.svg',
            'alt'       => 'WORLD AND LOCAL HITS',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
