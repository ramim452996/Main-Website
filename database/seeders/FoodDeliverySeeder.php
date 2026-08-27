<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FoodItem;
use App\Models\PromoCode;
use Illuminate\Database\Seeder;

class FoodDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Promo Codes
        $promos = [
            [
                'code' => 'TASTY30',
                'title' => '30% OFF First Order',
                'description' => 'Save 30% on gourmet meals over $25',
                'type' => 'percentage',
                'value' => 30.00,
                'min_spend' => 25.00,
                'is_active' => true,
            ],
            [
                'code' => 'FREEDEL',
                'title' => 'Zero Delivery Fee',
                'description' => 'Free express contactless delivery on orders above $20',
                'type' => 'free_delivery',
                'value' => 3.99,
                'min_spend' => 20.00,
                'is_active' => true,
            ],
            [
                'code' => 'CHEF15',
                'title' => '$15 Chef Discount',
                'description' => 'Flat $15 off on premium chef special orders over $50',
                'type' => 'fixed',
                'value' => 15.00,
                'min_spend' => 50.00,
                'is_active' => true,
            ],
            [
                'code' => 'BURGERDAY',
                'title' => '20% OFF Burgers',
                'description' => 'Special burger weekend discount',
                'type' => 'percentage',
                'value' => 20.00,
                'min_spend' => 15.00,
                'is_active' => true,
            ]
        ];

        foreach ($promos as $promo) {
            PromoCode::updateOrCreate(['code' => $promo['code']], $promo);
        }

        // 2. Categories & Food Items
        $catalog = [
            [
                'name' => 'Signature Burgers',
                'slug' => 'burgers',
                'icon' => 'beef',
                'tagline' => 'Prime Angus, Brioche buns & artisanal melted cheeses',
                'display_order' => 1,
                'items' => [
                    [
                        'name' => 'Truffle Umami Bacon Burger',
                        'slug' => 'truffle-umami-bacon-burger',
                        'description' => 'Double smash dry-aged Angus beef, crispy smoked applewood bacon, black truffle aioli, melted aged Gruyère cheese, and caramelized shallots on a toasted brioche bun.',
                        'price' => 18.50,
                        'original_price' => 22.00,
                        'rating' => 4.9,
                        'reviews_count' => 384,
                        'prep_time' => '15-20 min',
                        'calories' => 840,
                        'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => true,
                        'is_vegetarian' => false,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Best Seller', 'Chef Choice', 'Double Patty'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Single Patty (6oz)', 'price' => 0],
                                ['name' => 'Double Patty (12oz)', 'price' => 4.50],
                                ['name' => 'Triple Beast (18oz)', 'price' => 8.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Truffle Aioli', 'price' => 1.50],
                                ['name' => 'Crispy Smoked Bacon', 'price' => 2.50],
                                ['name' => 'Avocado Slices', 'price' => 2.00],
                                ['name' => 'Organic Fried Egg', 'price' => 1.75],
                                ['name' => 'Pickled Jalapeños', 'price' => 1.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Smoky Nashville Hot Chicken Burger',
                        'slug' => 'nashville-hot-chicken-burger',
                        'description' => 'Crispy buttermilk chicken breast drenched in fiery Nashville cayenne butter glaze, creamy house slaw, garlic pickles, and honey-drizzle kewpie mayo.',
                        'price' => 16.25,
                        'original_price' => 18.50,
                        'rating' => 4.8,
                        'reviews_count' => 290,
                        'prep_time' => '15-20 min',
                        'calories' => 760,
                        'image' => 'https://images.unsplash.com/photo-1625813506062-0aeb1d7a094b?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => false,
                        'is_spicy' => true,
                        'spice_level' => 3,
                        'tags' => ['Fiery Hot', 'Crispy', 'Popular'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Regular Cut', 'price' => 0],
                                ['name' => 'Jumbo Fillet', 'price' => 3.50],
                            ],
                            'toppings' => [
                                ['name' => 'Extra House Slaw', 'price' => 1.25],
                                ['name' => 'Ghost Pepper Sauce', 'price' => 1.50],
                                ['name' => 'Melted Cheddar', 'price' => 1.75],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Portobello Truffle Veggie Burger',
                        'slug' => 'portobello-truffle-veggie-burger',
                        'description' => 'Herb-marinated grilled Portobello mushroom cap stuffed with smoked provolone, roasted red bell peppers, baby arugula, and basil pesto on artisanal multigrain bun.',
                        'price' => 15.75,
                        'original_price' => null,
                        'rating' => 4.7,
                        'reviews_count' => 145,
                        'prep_time' => '12-18 min',
                        'calories' => 520,
                        'image' => 'https://images.unsplash.com/photo-1520072959219-c595dc870360?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => false,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Vegetarian', 'Plant Powered', 'Low Calorie'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Standard Stack', 'price' => 0],
                                ['name' => 'Double Mushroom Stack', 'price' => 4.00],
                            ],
                            'toppings' => [
                                ['name' => 'Goat Cheese Crumbles', 'price' => 2.00],
                                ['name' => 'Gluten-Free Bun', 'price' => 1.50],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Artisanal Pizza',
                'slug' => 'pizza',
                'icon' => 'pizza',
                'tagline' => '48h cold-fermented sourdough, San Marzano tomato & woodfired crust',
                'display_order' => 2,
                'items' => [
                    [
                        'name' => 'Neapolitan Burrata Margherita',
                        'slug' => 'burrata-margherita-pizza',
                        'description' => 'Hand-crushed San Marzano D.O.P tomatoes, creamy whole Italian burrata ball, fragrant sweet basil, extra virgin olive oil drizzle on charred sourdough crust.',
                        'price' => 21.00,
                        'original_price' => 25.00,
                        'rating' => 4.9,
                        'reviews_count' => 412,
                        'prep_time' => '18-22 min',
                        'calories' => 890,
                        'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => true,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Woodfired', 'Italian Burrata', 'Top Rated'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Medium 12"', 'price' => 0],
                                ['name' => 'Large 16"', 'price' => 6.00],
                            ],
                            'toppings' => [
                                ['name' => 'Prosciutto di Parma', 'price' => 4.00],
                                ['name' => 'Hot Honey Glaze', 'price' => 1.50],
                                ['name' => 'Kalamata Olives', 'price' => 1.75],
                                ['name' => 'Fresh Garlic Dip', 'price' => 1.25],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Hot Honey Double Pepperoni Supreme',
                        'slug' => 'hot-honey-pepperoni-pizza',
                        'description' => 'Crispy cupping pepperoni, spicy calabrese salami, whole milk shredded mozzarella, chili flakes, finished with organic chili-infused hot blossom honey.',
                        'price' => 23.50,
                        'original_price' => 26.00,
                        'rating' => 4.9,
                        'reviews_count' => 520,
                        'prep_time' => '15-20 min',
                        'calories' => 1020,
                        'image' => 'https://images.unsplash.com/photo-1628840042765-356cda07504e?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => false,
                        'is_spicy' => true,
                        'spice_level' => 2,
                        'tags' => ['Customer Favorite', 'Spicy Pepperoni'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Medium 12"', 'price' => 0],
                                ['name' => 'Large 16"', 'price' => 6.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Crispy Pepperoni', 'price' => 3.00],
                                ['name' => 'Creamy Ricotta Dollops', 'price' => 2.50],
                                ['name' => 'Ranch Dipping Sauce', 'price' => 1.25],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Wild Truffle & Wild Mushroom Bianco',
                        'slug' => 'wild-truffle-mushroom-pizza',
                        'description' => 'White garlic parmesan cream sauce, sautéed shiitake & cremini wild mushrooms, fresh thyme, fior di latte mozzarella, and white truffle oil.',
                        'price' => 22.75,
                        'original_price' => null,
                        'rating' => 4.8,
                        'reviews_count' => 198,
                        'prep_time' => '18-22 min',
                        'calories' => 870,
                        'image' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => false,
                        'is_chef_special' => true,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Gourmet Truffle', 'Vegetarian'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Medium 12"', 'price' => 0],
                                ['name' => 'Large 16"', 'price' => 6.00],
                            ],
                            'toppings' => [
                                ['name' => 'Caramelized Sweet Onions', 'price' => 1.50],
                                ['name' => 'Gorgonzola Crumbles', 'price' => 2.50],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Gourmet Asian & Sushi',
                'slug' => 'asian-sushi',
                'icon' => 'fish',
                'tagline' => 'Fresh sashimi grade salmon, slow-simmered rich broths & wok aromatics',
                'display_order' => 3,
                'items' => [
                    [
                        'name' => 'Tokyo Tonkotsu Black Garlic Ramen',
                        'slug' => 'tokyo-tonkotsu-ramen',
                        'description' => '24-hour slow-cooked silky pork bone broth, tender torched chashu pork belly, seasoned soft-boiled ramen egg, black garlic oil, bamboo shoots, and scallions.',
                        'price' => 19.50,
                        'original_price' => 22.50,
                        'rating' => 4.9,
                        'reviews_count' => 640,
                        'prep_time' => '15-20 min',
                        'calories' => 780,
                        'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => true,
                        'is_vegetarian' => false,
                        'is_spicy' => false,
                        'spice_level' => 1,
                        'tags' => ['Signature Broth', '24h Simmered', 'Best Seller'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Regular Bowl', 'price' => 0],
                                ['name' => 'Extra Noodle Refill (Kaedama)', 'price' => 2.50],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Chashu Pork (2pcs)', 'price' => 3.50],
                                ['name' => 'Extra Ajitsuke Tamago (Egg)', 'price' => 2.00],
                                ['name' => 'Spicy Chili Paste Ball', 'price' => 1.00],
                                ['name' => 'Nori Seaweed Sheets (4pcs)', 'price' => 1.25],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Torched Spicy Salmon Dragon Roll',
                        'slug' => 'torched-spicy-salmon-dragon-roll',
                        'description' => 'Tempura king prawn and avocado inside, wrapped with Atlantic salmon flame-torched tableside, spicy sriracha mayo, sweet unagi sauce, and crispy tobiko roe (8 pcs).',
                        'price' => 18.00,
                        'original_price' => 20.00,
                        'rating' => 4.9,
                        'reviews_count' => 310,
                        'prep_time' => '15-18 min',
                        'calories' => 540,
                        'image' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => true,
                        'is_vegetarian' => false,
                        'is_spicy' => true,
                        'spice_level' => 2,
                        'tags' => ['Fresh Catch', 'Flame Torched', 'Gluten Friendly'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Standard Roll (8 pcs)', 'price' => 0],
                                ['name' => 'Party Set (16 pcs)', 'price' => 16.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Pickled Ginger & Wasabi', 'price' => 1.00],
                                ['name' => 'Spicy Mayo Dip Cup', 'price' => 1.25],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Healthy Bowls & Greens',
                'slug' => 'healthy-bowls',
                'icon' => 'salad',
                'tagline' => 'Farm-to-table organic produce, nutrient-packed grain bases & superfoods',
                'display_order' => 4,
                'items' => [
                    [
                        'name' => 'Ahi Tuna & Mango Sunrise Poke Bowl',
                        'slug' => 'ahi-tuna-mango-poke-bowl',
                        'description' => 'Sashimi-grade yellowfin tuna, ripe mango cubes, Hass avocado, edamame, shredded purple cabbage, wakame seaweed salad over warm organic sushi rice with sesame ponzu.',
                        'price' => 18.90,
                        'original_price' => 21.00,
                        'rating' => 4.8,
                        'reviews_count' => 280,
                        'prep_time' => '10-15 min',
                        'calories' => 490,
                        'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => false,
                        'is_spicy' => false,
                        'spice_level' => 1,
                        'tags' => ['High Protein', 'Gluten-Free', 'Superfood'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Regular Bowl', 'price' => 0],
                                ['name' => 'Protein Monster Bowl (+50% Tuna)', 'price' => 4.50],
                            ],
                            'toppings' => [
                                ['name' => 'Spicy Sesame Drizzle', 'price' => 0.75],
                                ['name' => 'Crispy Wonton Strips', 'price' => 1.00],
                                ['name' => 'Extra Hass Avocado', 'price' => 2.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Mediterranean Grilled Halloumi & Quinoa',
                        'slug' => 'mediterranean-halloumi-quinoa-bowl',
                        'description' => 'Crispy Cypriot grilled halloumi cheese, roasted chickpeas, organic tri-color quinoa, heirloom cherry tomatoes, cucumber, Kalamata olives, and lemon-tahini herb dressing.',
                        'price' => 16.50,
                        'original_price' => null,
                        'rating' => 4.7,
                        'reviews_count' => 175,
                        'prep_time' => '10-14 min',
                        'calories' => 510,
                        'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => false,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Vegetarian', 'Clean Eating', 'Fiber Rich'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Standard Bowl', 'price' => 0],
                                ['name' => 'Large Salad Bowl', 'price' => 3.50],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Grilled Halloumi (3pcs)', 'price' => 3.00],
                                ['name' => 'Warm Pita Bread Triangle', 'price' => 1.50],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Desserts & Bakery',
                'slug' => 'desserts',
                'icon' => 'cake',
                'tagline' => 'Handcrafted French pastries, Belgian chocolate & velvet cheesecakes',
                'display_order' => 5,
                'items' => [
                    [
                        'name' => 'Molten Belgian Chocolate Lava Cake',
                        'slug' => 'molten-chocolate-lava-cake',
                        'description' => 'Warm 70% dark Belgian cocoa sponge oozing with molten ganache center, served with Madagascar bourbon vanilla bean ice cream and raspberry coulis.',
                        'price' => 11.50,
                        'original_price' => 13.00,
                        'rating' => 4.9,
                        'reviews_count' => 450,
                        'prep_time' => '10-12 min',
                        'calories' => 580,
                        'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Warm Dessert', 'Sweet Tooth Favorite'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Single Cake', 'price' => 0],
                                ['name' => 'Twin Shareable Cakes', 'price' => 9.50],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Vanilla Ice Cream Scoop', 'price' => 2.50],
                                ['name' => 'Fresh Wild Berries Medley', 'price' => 2.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Matcha Pistachio Basque Burnt Cheesecake',
                        'slug' => 'matcha-pistachio-cheesecake',
                        'description' => 'Caramelized burnt exterior with an ultra-creamy Uji ceremonial matcha center, roasted Sicilian pistachio praline paste, and gold leaf flake.',
                        'price' => 12.00,
                        'original_price' => null,
                        'rating' => 4.8,
                        'reviews_count' => 210,
                        'prep_time' => '5-10 min',
                        'calories' => 460,
                        'image' => 'https://images.unsplash.com/photo-1535141192574-5d4897c13136?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => false,
                        'is_chef_special' => true,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Artisanal', 'Ceremonial Matcha'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Generous Slice', 'price' => 0],
                                ['name' => 'Whole 6" Cake (Pre-order)', 'price' => 38.00],
                            ],
                            'toppings' => [
                                ['name' => 'Salted Caramel Drizzle', 'price' => 1.25],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Handcrafted Drinks',
                'slug' => 'drinks',
                'icon' => 'coffee',
                'tagline' => 'Cold brew, pressed elixirs, botanical mocktails & bubble teas',
                'display_order' => 6,
                'items' => [
                    [
                        'name' => 'Smoked Blackberry Nitro Cold Brew',
                        'slug' => 'smoked-blackberry-nitro-cold-brew',
                        'description' => 'Single-origin Ethiopian Yirgacheffe coffee steeped for 24 hours, infused with nitrogen foam, wild blackberry syrup, and a hint of smoked vanilla.',
                        'price' => 7.50,
                        'original_price' => 9.00,
                        'rating' => 4.8,
                        'reviews_count' => 180,
                        'prep_time' => '3-5 min',
                        'calories' => 120,
                        'image' => 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Specialty Coffee', 'Nitro Infused', 'Energizing'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Regular 16oz', 'price' => 0],
                                ['name' => 'Large 24oz', 'price' => 1.75],
                            ],
                            'toppings' => [
                                ['name' => 'Oat Milk Float', 'price' => 0.75],
                                ['name' => 'Extra Espresso Shot', 'price' => 1.25],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Dragonfruit Lychee Sparkler Mocktail',
                        'slug' => 'dragonfruit-lychee-sparkler',
                        'description' => 'Fresh crushed red dragonfruit, floral lychee puree, organic sparkling mint water, lime zest, and crystal aloe jelly pearls over crushed ice.',
                        'price' => 7.00,
                        'original_price' => null,
                        'rating' => 4.9,
                        'reviews_count' => 310,
                        'prep_time' => '3-5 min',
                        'calories' => 110,
                        'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Refreshing', '100% Natural', 'Zero Alcohol'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Regular 16oz', 'price' => 0],
                                ['name' => 'Large 24oz', 'price' => 1.75],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Lychee Boba Pearls', 'price' => 1.00],
                                ['name' => 'Chia Seeds Boost', 'price' => 0.75],
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($catalog as $catData) {
            $items = $catData['items'];
            unset($catData['items']);

            $category = Category::updateOrCreate(['slug' => $catData['slug']], $catData);

            foreach ($items as $itemData) {
                $itemData['category_id'] = $category->id;
                FoodItem::updateOrCreate(['slug' => $itemData['slug']], $itemData);
            }
        }
    }
}
