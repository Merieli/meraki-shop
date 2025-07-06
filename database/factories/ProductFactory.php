<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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

        if (! self::$products) {
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
                    'sku' => 'FU75870',
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
                    'sku' => 'HSG1565',
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
                    'sku' => 'FU87QV65344EE',
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
                    'sku' => 'HSG0670',
                ],
                [
                    'name' => 'Star Wars: The Mandalorian Ashigaru Outer Rim Remnant Stormtrooper Meisho Movie Realization Action Figure',
                    'price' => 11499,
                    'cost_price' => 4999,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/star-wars/mandaloriam-ashigaru.jpg',
                    'short_description' => 'The foot soldiers of the Empire return to the Meisho Movie Realization series, this time in the form of the Outer Rim Remnant Stormtroopers as seen on',
                    'description' => ' With armor weathered and battered by countless battles, this version of the Ashigaru Stormtrooper also includes a Camtono container with Beskar ingots rendered in the Meisho style similar to what was seen held by the Stormtroopers guarding The Client\'s stronghold on Navarro. Figure is made of plastic and stands slightly over 7-inches tall.',
                    'rating' => 4,
                    'sku' => 'BLFBAS65072',
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
                    'sku' => 'DC85280',
                ],
                [
                    'name' => 'Rocket Raccoon - Guardians of the Galaxy 3 - Art Scale 1/10',
                    'price' => 9999,
                    'cost_price' => 3999,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/rocket-raccoon.png',
                    'short_description' => 'Iron Studios',
                    'description' => 'Sitting on a wall of electronic components inside the mobile research complex Arête Laboratories, the most sarcastic, foul-mouthed and cynical raccoon in the galaxy holds a blaster pistol in his right hand while in the other he carries his improvised keycard made from scrap metal to open the cages in Arête Laboratories. Dressed in his blue uniform with red accents, he joins his friends and allies to face his nemesis, and free innocent prisoners from a tragic fate at the hands of their creator, a madman obsessed with creating the perfect species from what he considered inferior life forms, and building his own utopia. Revealed first-hand at San Diego Comic Con 2023 at its stand, Iron Studios brings the statue "Rocket Raccoon - Guardians of the Galaxy Vol. 3 - Art Scale 1/10", the future new leader of the Guardians of the Galaxy on a diorama base that refers to the interior of the villain High Evolutionary\'s mobile research complex, in a new series where the statues of Groot and Star-Lord complete the scene.',
                    'rating' => 5,
                    'sku' => '250398_0_0_U',
                ],
                [
                    'name' => 'Shuri Black Panther - Black Panther Wakanda Forever - Sixth Scale',
                    'price' => 39999,
                    'cost_price' => 19999,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/shuri-black-panther.png',
                    'short_description' => 'Hot Toys',
                    'rating' => 5,
                    'sku' => '312595_0_0_U',
                ],
                [
                    'name' => 'Old Logan - Wolverine - X-Men',
                    'price' => 39999,
                    'cost_price' => 19999,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/old-logan.png',
                    'short_description' => 'Art Scale 1/10 - Iron Studios',
                    'description' => 'In a possible future where his enemies have prevailed and most of his allies have fallen, an old mutant warrior is unable to let go of his traumatic past and once again uses his claws in search of revenge and justice, hunting down those responsible for destroying his new life and deciding to eliminate all the villains of the new world and bring peace to Earth. On a base in the arid territory known as Hulkland, setting off on his mission with his luggage on his back, the reluctant hero continues wearing boots with iron toes, and wearing a leather overcoat over his worn-out t-shirt and jeans, and covering his head with a wide hat. Thus, Iron Studios presents its statue "Old Man Logan (Wolverine 50th Anniversary) - Marvel Comics - Art Scale 1/10", featuring the most popular X-Men superhero in his acclaimed aged alternative version from the 2008 Wolverine story arc written by Mark Millar and illustrated by Steve McNiven.',
                    'rating' => 5,
                    'sku' => '312595_0_0_U',
                ],
                [
                    'name' => 'Obi-Wan Kenobi',
                    'price' => 59999,
                    'cost_price' => 9999,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/obi-wan-kenobi_star-wars_scale_6.png',
                    'short_description' => 'Star Wars - Sixth Scale Figure by Hot Toys',
                    'description' => 'During the reign of the Galactic Empire, former Jedi™ Master, Obi-Wan Kenobi, embarked on a crucial mission. The once legendary Jedi must confront Darth Vader™ and face the wrath of the Empire… After witnessing the climactic finale of the Obi-Wan Kenobi live-action series, Sideshow and Hot Toys are thrilled to officially introduce the new Obi-Wan Kenobi Sixth Scale Collectible Figure from the DX series!  ',
                    'rating' => 5,
                    'sku' => '9114112',
                ],
                [
                    'name' => 'Iron Man Mark V',
                    'price' => 79999,
                    'cost_price' => 39999,
                    'stock' => 1,
                    'thumbnail' => 'https://cdn.statically.io/gh/Merieli/meraki-shop/main/.images-cdn/products/iron-man.png',
                    'short_description' => 'Sixth Scale Figure by Hot Toys',
                    'description' => 'Sideshow and Hot Toys present the reissued Iron Man Mark V Sixth Scale Collectible Figure for fans who had missed its first release! Inspired by the signature appearance of Iron Man Mark V in Iron Man 2, the truly detailed "Suitcase Armor" figure in diecast has articulated armor pieces and highly poseable structure to recreate the film scenes.',
                    'rating' => 5,
                    'sku' => '907514',
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
