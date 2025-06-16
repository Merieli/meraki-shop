<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use MerakiShop\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\MerakiShop\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Coleção de produtos padrões
     */
    protected static $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        if (!self::$products) {
            self::$products = collect([
                [
                    'name' => 'Spider-Man Final Suit Funko Pop!',
                    'price' => 1499,
                    'cost_price' => 499,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/spider-man-funko.jpg',
                    // 'images' => json_encode(['products/galaxy-s23-1.jpg', 'products/galaxy-s23-2.jpg']),
                    'short_description' => 'Your Friendly Neighborhood Spider-Man Final Suit Funko Pop! Vinyl Figure #1526',
                    'description' => 'A new web-slinging hero is on the rise. Bring home the origin story with the Friendly Neighborhood Spider-Man! Expand your Marvel"
                    set by adding this hero to your Funko Pop! collection. This Your Friendly Neighborhood Spider-Man Final Suit Funko Pop! Vinyl Figure #1526 measures approximately 4-inches tall and comes packaged in a window display box. Ages 3 and up',
                    'rating' => 4,
                    'sku' => 'FU75870'
                ],
                [
                    'name' => 'Star Wars The Black Series Sandtrooper 6-Inch Action Figure',
                    'price' => 2699,
                    'cost_price' => 1099,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/sandtropper.png',
                    'short_description' => 'Star Wars Hasbro Action Figures of 6-Inch',
                    'description' => 'Nicknamed sandtroopers, these stormtroopers wear armor augmented with cooling units, a helmet sand filter, and a survival backpack with rations and water. STAR WARS: THE BLACK SERIES includes 6-inch action figures, vehicles, and roleplay items from the 40-plus-year legacy of the STAR WARS Galaxy, letting fans create galactic scenes with a faithfulness to STAR WARS comic books, movies, series, and more. This STAR WARS Hasbro action figure is detailed to look like a sandtrooper from STAR WARS: A NEW HOPE.  Features a poseable head, arms, and legs so fans can create dynamic poses for display and comes with 2 blaster accessories and a removable backpack. Display STAR WARS fandom on your shelf with window box packaging featuring sleek character art. Look for more STAR WARS figures to recreate scenes from the original trilogy on your shelf (each sold separately, subject to availability).  Ages 4 and up.',
                    'rating' => 5,
                    'sku' => 'HSG1565'
                ],
                [
                    'name' => 'Black Adam Hawkman Vinyl Funko Soda Figure',
                    'price' => 2790,
                    'cost_price' => 1900,
                    'stock' => 30,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/black-adam-hawkman-fuko.jpg',
                    'short_description' => '2022 Convention Exclusive',
                    'description' => 'This very special item might have limited variants randomly inserted throughout the production run. If extra lucky, you could potentially receive one of these highly sought-after ultra-rare collectibles when you order this item! Please note that we cannot accept requests for specific variants upon ordering, nor can we accept returns of opened items. And the item you receive may be slightly different from the standard edition pictured. Some attached images may include a picture of the prized variant.<br><br>In case you didn\'t know: What is a "chase variant" and why is it so special? Well, variants are slightly different productions made in limited number and inserted into the standard production run. Kind of like a golden ticket, you just never know when you might receive one! These variants are often called chase items because they\'re the versions that the most enthusiastic collectors are always chasing after to get. When you purchase multiple units, it can increase your chance of landing one of these popular treasures. However, chase pieces are not guaranteed.',
                    'rating' => 2,
                    'sku' => 'FU87QV65344EE'
                ],
                [
                    'name' => 'Star Wars The Vintage Collection IG-12, Grogu & Anzellan Deluxe',
                    'price' => 2499,
                    'cost_price' => 1199,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/star-wars/grogu-anzellan-deluxe.png',
                    'short_description' => 'Star Wars The Vintage Collection IG-12, Grogu & Anzellan Deluxe 3 3/4-Inch',
                    'description' => 'Celebrate the legacy of Star Wars with premium vehicles, playsets, and action figures from Star Wars The Vintage Collection. (Additional products each sold separately. Subject to availability.) Based on IG-12, Grogu & an Anzellan from Star Wars: The Mandalorian, these 3 3/4-inch-scale figures make a great addition to any fan’s collection. Inspired by the original line, these collectibles feature premium detail and design across product and packaging, as well as collector-grade deco that fans have come to know and love. May the Force be with you! Ages 4 and up.',
                    'rating' => 2,
                    'sku' => 'HSG0670'
                ],
                [
                    'name' => 'Star Wars: The Mandalorian Ashigaru Outer Rim Remnant Stormtrooper Meisho Movie Realization Action Figure',
                    'price' => 11499,
                    'cost_price' => 4999,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/star-wars/mandalorian-ashigaru.jpg',
                    'short_description' => 'The foot soldiers of the Empire return to the Meisho Movie Realization series, this time in the form of the Outer Rim Remnant Stormtroopers as seen on',
                    'description' => ' With armor weathered and battered by countless battles, this version of the Ashigaru Stormtrooper also includes a Camtono container with Beskar ingots rendered in the Meisho style similar to what was seen held by the Stormtroopers guarding The Client\'s stronghold on Navarro. Figure is made of plastic and stands slightly over 7-inches tall.',
                    'rating' => 4,
                    'sku' => 'BLFBAS65072'
                ],
                [
                    'name' => 'Star Wars Gallery Clone Wars Ahsoka Statue',
                    'price' => 8699,
                    'cost_price' => 4999,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/star-wars/ahsoka.jpg',
                    'short_description' => 'Star Wars Diamond Select Statues and Busts',
                    'description' => 'The Padawan attacks! Ahsoka Tano swings her two lightsabers in front of an explosion as this Star Wars Gallery plastic statue!Made of high-quality plastic, this approximately 8-inch tall statue features interchangeable blades that appear to be moving or non-moving. The perfect companion to the Obi-WanGallery Statue, it comes packaged in a full-color windowbox.',
                    'rating' => 5,
                    'sku' => 'DC85280'
                ],
            ]);
        }
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return self::$products->random();
    }

    /**
     * Retorna a coleção completa de produtos
     */
    public function getProducts()
    {
        return self::$products;
    }
}
