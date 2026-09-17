<?php
/**
 * Menu Section — Cocktails
 *
 * @package Sweet_Pepper
 */
?>

<section id="cocktails" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/cocktails/manhattan-4-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Manhattan' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Manhattan' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'shake & stir' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'cocktails' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right">
                <!-- Deal: Spritz Time! -->
                <div class="menu-section__deal">
                    <div class="menu-section__deal-inner">
                        <div class="menu-section__deal-card">
                            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( 'Spritz Time!' ); ?></div>
                            <div class="menu-section__deal-divider"></div>
                            <div class="menu-section__deal-desc">
                                <span class="menu-section__deal-desc-main"><?php echo esc_html( 'Aperol, Campari or Sarti' ); ?></span>
                                <span class="menu-section__deal-desc-sub"><?php echo esc_html( 'any spritz — 425-.' ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="menu-section__deal-shadow"></div>
                </div>
            </div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: world classics + only at pepper -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: world classics -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'world classics' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Paloma',
                            'price'       => '445-.',
                            'quantity'    => '350 ml',
                            'description' => 'Tequila, fresh lemon, sugar, grapefruit juice, salt.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Piña Colada',
                            'price'       => '445-.',
                            'quantity'    => '300 ml',
                            'description' => 'Rum, pineapple, coconut cream.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Old Cuban',
                            'price'       => '445-.',
                            'quantity'    => '180 ml',
                            'description' => 'Takamaka Noir rum, fresh lemon, mint, sugar, angostura, sparkling wine.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'La Manche',
                            'price'       => '445-.',
                            'quantity'    => '150 ml',
                            'description' => "Pogues Irish whiskey, cassis liqueur, Atxa vermouth, Peychaud's bitters.",
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'New York Sour',
                            'price'       => '445-.',
                            'quantity'    => '200 ml',
                            'description' => 'Old Virginia whiskey, fresh lemon, sugar syrup, egg white, Merlot wine.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Irish Coffee',
                            'price'       => '445-.',
                            'quantity'    => '190 ml',
                            'description' => 'Pogues Irish whiskey, double espresso, cane sugar, cream.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Negroni Sbagliato',
                            'price'       => '445-.',
                            'quantity'    => '150 ml',
                            'description' => 'Campari bitter, Atxa vermouth, brut sparkling.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Penicillin',
                            'price'       => '485-.',
                            'quantity'    => '150 ml',
                            'description' => 'Pogues Irish whiskey, fresh lemon, egg white, sugar syrup, Laphroaig whisky.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: only at pepper -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'only at pepper' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'April',
                            'price'       => '355-.',
                            'quantity'    => '250 ml',
                            'description' => 'Rhubarb gin, fresh lemon, elderflower syrup, cranberry-orange-honey foam.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Raspberry Twist',
                            'price'       => '355-.',
                            'quantity'    => '190 ml',
                            'description' => 'Raspberry gin infusion, fresh lemon, sugar syrup, egg white.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'The Depths',
                            'price'       => '355-.',
                            'quantity'    => '300 ml',
                            'description' => 'Lemon infusion, Blue Curaçao, fresh lemon, lemon-lime lemonade.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Sarti Martini',
                            'price'       => '355-.',
                            'quantity'    => '150 ml',
                            'description' => 'Sarti Aperitivo, fresh lemon, vanilla syrup, brut sparkling.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Coco Mademoiselle',
                            'price'       => '355-.',
                            'quantity'    => '200 ml',
                            'description' => 'Salted caramel infusion, advocaat, coconut-passion fruit foam.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Dragon Warrior',
                            'price'       => '445-.',
                            'quantity'    => '350 ml',
                            'description' => 'Vodka, peach liqueur, fresh lemon, raspberry syrup, grapefruit juice.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => "Granny's Long",
                            'price'       => '445-.',
                            'quantity'    => '350 ml',
                            'description' => 'Raspberry gin, cherry cognac, cranberry, blackcurrant, berry juice.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Rongo',
                            'price'       => '445-.',
                            'quantity'    => '350 ml',
                            'description' => 'Rum, passion fruit syrup, fresh lemon, peach juice, pineapple juice.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: seasonal drinks + long drinks + mixed drinks + shots -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: seasonal drinks -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'seasonal drinks' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Lilian',
                            'price'          => '355-.',
                            'quantity'       => '250 ml',
                            'description'    => 'Blackberry gin, fresh lemon, sugar syrup, sorrel-apple foam.',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Emmanuelle',
                            'price'          => '355-.',
                            'quantity'       => '350 ml',
                            'description'    => 'Strawberry infusion, fresh lemon, sugar, egg white, soda, basil mist.',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Gemini',
                            'price'          => '355-.',
                            'quantity'       => '250 ml',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: long drinks -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'long drinks' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Long Island Iced Tea',
                            'price'       => '550-.',
                            'quantity'    => '350 ml',
                            'description' => 'Rum, vodka, gin, tequila, orange liqueur, fresh lemon, cola.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Mai Tai',
                            'price'       => '550-.',
                            'quantity'    => '350 ml',
                            'description' => 'White & dark rum, orange liqueur, almond syrup, fresh lemon, juices.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'AI-99',
                            'price'       => '550-.',
                            'quantity'    => '350 ml',
                            'description' => 'Rum, vodka, gin, tequila, orange liqueur, Blue Curaçao, lemonade.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: mixed drinks -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'mixed drinks' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Gin & Tonic',
                            'price'       => '245-.',
                            'quantity'    => '250 ml',
                            'description' => 'Mango-papaya or Cucumber or Classic.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Rum & Cola',
                            'price'       => '265-.',
                            'quantity'    => '250 ml',
                            'description' => 'A timeless two-ingredient classic.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Whisky & Cola',
                            'price'       => '265-.',
                            'quantity'    => '250 ml',
                            'description' => 'Smooth and refreshing.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: shots -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'shots' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Jellyfish',
                            'price'       => '345-.',
                            'quantity'    => '50 ml',
                            'description' => 'Sambuca, orange liqueur, rum, Baileys, Blue Curaçao.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'B-52',
                            'price'       => '345-.',
                            'quantity'    => '50 ml',
                            'description' => 'Baileys, coffee liqueur, orange liqueur.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Slippery Nipple',
                            'price'       => '345-.',
                            'quantity'    => '50 ml',
                            'description' => 'Sambuca, Baileys, grenadine syrup.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Brain Hemorrhage',
                            'price'       => '325-.',
                            'quantity'    => '50 ml',
                            'description' => 'Peach liqueur, Baileys, grenadine syrup.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Boyarsky',
                            'price'       => '235-.',
                            'quantity'    => '50 ml',
                            'description' => 'Vodka, grenadine syrup, Tabasco.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Quickshot',
                            'price'       => '345-.',
                            'quantity'    => '50 ml',
                            'description' => 'Coffee liqueur, salted caramel infusion, whipped cream.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => "Angel's Tits",
                            'price'       => '265-.',
                            'quantity'    => '50 ml',
                            'description' => 'Our Advocaat infusion, sambuca, maraschino cherry.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: THE BEST IN THE CITY -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/thebestinthecity.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/thebestinthecity.svg',
            'alt'       => 'THE BEST IN THE CITY',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
