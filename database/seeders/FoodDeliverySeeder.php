<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FoodItem;
use App\Models\PromoCode;
use Illuminate\Database\Seeder;

class FoodDeliverySeeder extends Seeder
{
    /**
     * Run the database seeds for Kushtia, Bangladesh Food Delivery.
     */
    public function run(): void
    {
        // 1. Kushtia Specific Promo Codes (in BDT ৳)
        $promos = [
            [
                'code' => 'KUSHTIA50',
                'title' => '৳৫০ ছাড় প্রথম অর্ডারে',
                'description' => 'কুষ্টিয়া শহরের যেকোনো অর্ডারে ৳৩০০ এর উপর ৳৫০ ছাড়!',
                'type' => 'fixed',
                'value' => 50.00,
                'min_spend' => 300.00,
                'is_active' => true,
            ],
            [
                'code' => 'GORAI',
                'title' => 'ফ্রি হোম ডেলিভারি',
                'description' => '৳৪০০ এর যেকোনো অর্ডারে কুষ্টিয়া পৌরসভা এলাকায় ফ্রি ডেলিভারি',
                'type' => 'free_delivery',
                'value' => 40.00,
                'min_spend' => 400.00,
                'is_active' => true,
            ],
            [
                'code' => 'KACHI100',
                'title' => '৳১০০ মেগা ডিসকাউন্ট',
                'description' => 'ফ্যামিলি কাচ্চি ও স্পেশাল প্ল্যাটার অর্ডারে ৳১০০ ডিসকাউন্ট',
                'type' => 'fixed',
                'value' => 100.00,
                'min_spend' => 800.00,
                'is_active' => true,
            ],
            [
                'code' => 'KULFI20',
                'title' => '২০% মিষ্টি ও কুলফি ছাড়',
                'description' => 'কুষ্টিয়ার বিখ্যাত কুলফি মালাই ও মিষ্টান্নে ২০% ছাড়',
                'type' => 'percentage',
                'value' => 20.00,
                'min_spend' => 200.00,
                'is_active' => true,
            ]
        ];

        foreach ($promos as $promo) {
            PromoCode::updateOrCreate(['code' => $promo['code']], $promo);
        }

        // 2. Categories & Authentic Kushtia / Bengali Food Items
        $catalog = [
            [
                'name' => 'Kushtia Heritage & Kulfi',
                'slug' => 'kushtia-heritage',
                'icon' => 'ice-cream',
                'tagline' => 'কুষ্টিয়ার শতাব্দী প্রাচীন বিখ্যাত কুলফি মালাই ও তিলের খাজা',
                'display_order' => 1,
                'items' => [
                    [
                        'name' => 'Kushtia Famous Royal Shahi Kulfi Malai',
                        'slug' => 'kushtia-royal-kulfi-malai',
                        'description' => 'কুষ্টিয়ার খাঁটি ঘন ক্ষীর, পেস্তা বাদাম, কাজুবাদাম ও জাফরান দিয়ে তৈরি ঐতিহ্যবাহী বিখ্যাত কুলফি মালাই। মুখে দিলেই স্বর্গীয় স্বাদ!',
                        'price' => 120.00,
                        'original_price' => 150.00,
                        'rating' => 5.0,
                        'reviews_count' => 890,
                        'prep_time' => '10-15 min',
                        'calories' => 280,
                        'image' => 'https://images.unsplash.com/photo-1587314168485-3236d6710814?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => true,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Kushtia Special', 'Top Seller', 'Pure Milk'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Standard Pot (1 Pc)', 'price' => 0],
                                ['name' => 'Double Joy Box (2 Pcs)', 'price' => 110.00],
                                ['name' => 'Family Pack (4 Pcs)', 'price' => 220.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Saffron & Roasted Pistachio', 'price' => 30.00],
                                ['name' => 'Sweet Rabri Layer Drizzle', 'price' => 40.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Traditional Kushtia Til Khaja & Chomchom Platter',
                        'slug' => 'traditional-til-khaja-chomchom',
                        'description' => 'কুষ্টিয়ার বিখ্যাত ক্রিস্পি তিলের খাজা ও খাঁটি ছানার সুস্বাদু চমচম ও কাঁচাগোল্লা বক্স।',
                        'price' => 250.00,
                        'original_price' => 290.00,
                        'rating' => 4.9,
                        'reviews_count' => 420,
                        'prep_time' => '10-15 min',
                        'calories' => 450,
                        'image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Heritage Food', 'Sweet Lover'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Half Box (250g)', 'price' => 0],
                                ['name' => 'Full Box (500g)', 'price' => 220.00],
                            ],
                            'toppings' => [
                                ['name' => 'Mawa Topping Powder', 'price' => 25.00],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Biryani & Polao Kitchen',
                'slug' => 'biryani-polao',
                'icon' => 'bowl-rice',
                'tagline' => 'বাসমতি চাল, খাঁটি গাওয়া ঘি ও রসালো মাংসে রান্না করা দম বিরিয়ানি',
                'display_order' => 2,
                'items' => [
                    [
                        'name' => 'Special Shahi Mutton Kachi Biryani with Borhani',
                        'slug' => 'shahi-mutton-kachi-biryani',
                        'description' => 'বাসমতি চাল, প্রিমিয়াম খাসির মাংস, আলু বোখারা ও খাঁটি গাওয়া ঘিয়ে জাফরানি দমে রান্না করা কাচ্চি বিরিয়ানি। সাথে ১ গ্লাস স্পেশাল বোরহানি ও ডিম।',
                        'price' => 420.00,
                        'original_price' => 480.00,
                        'rating' => 4.9,
                        'reviews_count' => 740,
                        'prep_time' => '15-20 min',
                        'calories' => 880,
                        'image' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => true,
                        'is_vegetarian' => false,
                        'is_spicy' => false,
                        'spice_level' => 1,
                        'tags' => ['Must Try', 'Bestseller', 'Free Borhani'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => '1:1 Single Plate', 'price' => 0],
                                ['name' => '1:2 Double Meat Platter', 'price' => 380.00],
                                ['name' => '1:4 Family Feast Pack', 'price' => 1150.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Shahi Mutton Piece', 'price' => 180.00],
                                ['name' => 'Extra Fried Egg (ডিম)', 'price' => 25.00],
                                ['name' => 'Extra 250ml Spicy Borhani', 'price' => 50.00],
                                ['name' => 'Sweet Jorda (জর্দা)', 'price' => 60.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Old Town Morog Polao with Roast Chicken Leg',
                        'slug' => 'old-town-morog-polao',
                        'description' => 'সুগন্ধি চিনিগুঁড়া চালের ঝরঝরে পোলাও এবং ঐতিহ্যবাহী বাদাম-কিসমিস বাটা গ্রেভিতে রান্না করা মুরগির রোস্ট ও ঝাল চাটনি।',
                        'price' => 320.00,
                        'original_price' => 360.00,
                        'rating' => 4.8,
                        'reviews_count' => 510,
                        'prep_time' => '15-20 min',
                        'calories' => 740,
                        'image' => 'https://images.unsplash.com/photo-1589302168068-964664d93dc0?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => false,
                        'is_spicy' => false,
                        'spice_level' => 1,
                        'tags' => ['Deshi Chicken', 'Traditional'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Regular Serving (1 Chicken Leg)', 'price' => 0],
                                ['name' => 'Double Roast Special', 'price' => 160.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Roast Chicken Leg', 'price' => 140.00],
                                ['name' => 'Fresh Salad & Green Chili Chutney', 'price' => 20.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Special Beef Tehari with Mustard Oil',
                        'slug' => 'special-beef-tehari',
                        'description' => 'খাঁটি সরিষার তেলে ছোট ছোট নরম গরুর মাংসের টুকরো দিয়ে রান্না করা ঝাল ঝাল স্পেশাল গরুর তেহারি।',
                        'price' => 290.00,
                        'original_price' => 330.00,
                        'rating' => 4.8,
                        'reviews_count' => 630,
                        'prep_time' => '15-20 min',
                        'calories' => 810,
                        'image' => 'https://images.unsplash.com/photo-1633945274405-b6c8069047b0?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => false,
                        'is_spicy' => true,
                        'spice_level' => 2,
                        'tags' => ['Mustard Oil', 'Spicy Tehari'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Single Plate', 'price' => 0],
                                ['name' => 'Large Plate (+50% Meat)', 'price' => 120.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Green Chillies & Lime', 'price' => 15.00],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Bengali Curry & Gorai Fish',
                'slug' => 'bengali-curry-fish',
                'icon' => 'fish',
                'tagline' => 'কুষ্টিয়ার গড়াই ও পদ্মা নদীর টাটকা ইলিশ এবং স্পেশাল কালা ভুনা',
                'display_order' => 3,
                'items' => [
                    [
                        'name' => 'Gorai Fresh Ilish Bhuna / Shorshe Ilish (পদ্মার ইলিশ)',
                        'slug' => 'gorai-fresh-shorshe-ilish',
                        'description' => 'কুষ্টিয়া গড়াই নদী ও পদ্মা নদীর তাজা বড় ইলিশ মাছের পেটি, খাঁটি সরিষা বাটা ও কাঁচা মরিচে রান্না করা লোভনীয় সরষে ইলিশ।',
                        'price' => 450.00,
                        'original_price' => 520.00,
                        'rating' => 4.9,
                        'reviews_count' => 490,
                        'prep_time' => '20-25 min',
                        'calories' => 610,
                        'image' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => true,
                        'is_vegetarian' => false,
                        'is_spicy' => true,
                        'spice_level' => 2,
                        'tags' => ['Fresh Catch', 'River Ilish', 'Kushtia Favorite'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => '1 Big Ilish Piece', 'price' => 0],
                                ['name' => '2 Pieces Shorshe Platter', 'price' => 420.00],
                            ],
                            'toppings' => [
                                ['name' => 'Steamed Fragrant Basmati Rice (1 Plate)', 'price' => 60.00],
                                ['name' => 'Ilish Fried Egg / Tel', 'price' => 80.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Kushtia Royal Beef Kala Bhuna with Butter Naan',
                        'slug' => 'kushtia-royal-beef-kala-bhuna',
                        'description' => 'বিশেষ মসলায় মৃদু আঁচে ঘণ্টার পর ঘণ্টা ভুনা করা নরম, তুলতুলে গরুর কালা ভুনা। সাথে ২টি গরম গরম বাটার নান।',
                        'price' => 380.00,
                        'original_price' => 430.00,
                        'rating' => 5.0,
                        'reviews_count' => 920,
                        'prep_time' => '15-20 min',
                        'calories' => 780,
                        'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => true,
                        'is_vegetarian' => false,
                        'is_spicy' => true,
                        'spice_level' => 2,
                        'tags' => ['Signature Item', 'Chef Choice', 'Tender Beef'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Standard Bowl (with 2 Naans)', 'price' => 0],
                                ['name' => 'Large Bowl (with 4 Naans)', 'price' => 280.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Butter Naan (1 Pc)', 'price' => 40.00],
                                ['name' => 'Garlic Naan Upgrade', 'price' => 30.00],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Burgers & Fast Food',
                'slug' => 'burgers-fast-food',
                'icon' => 'beef',
                'tagline' => 'চিজি গ্রিলড বার্গার, ক্রিস্পি ফ্রাইড চিকেন ও নাগা স্পেশাল',
                'display_order' => 4,
                'items' => [
                    [
                        'name' => 'Cheesy Naga Smoky Chicken Burger',
                        'slug' => 'cheesy-naga-smoky-chicken-burger',
                        'description' => 'স্মোকি গ্রিলড চিকেন প্যাটি, খাঁটি নাগা মরিচের সস, গলিত চিজ ও মেয়োনিজের দারুণ জুগলবন্দী।',
                        'price' => 240.00,
                        'original_price' => 280.00,
                        'rating' => 4.8,
                        'reviews_count' => 340,
                        'prep_time' => '15-18 min',
                        'calories' => 650,
                        'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => false,
                        'is_spicy' => true,
                        'spice_level' => 3,
                        'tags' => ['Naga Blast', 'Cheesy', 'Youth Favorite'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Single Patty', 'price' => 0],
                                ['name' => 'Double Smash Patty (+৳৮০)', 'price' => 80.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Melted Cheddar Slice', 'price' => 35.00],
                                ['name' => 'Crispy French Fries (Small)', 'price' => 60.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'BBQ Supreme Crispy Chicken Pizza 10"',
                        'slug' => 'bbq-supreme-chicken-pizza',
                        'description' => 'হাতে তৈরি পাতলা ক্রাস্টের ওপর প্রিমিয়াম চিকেন টিকিয়া, বারবিকিউ সস, ক্যাপসিকাম, ব্ল্যাক অলিভ ও ভরপুর মোজারেলা চিজ।',
                        'price' => 480.00,
                        'original_price' => 550.00,
                        'rating' => 4.9,
                        'reviews_count' => 410,
                        'prep_time' => '20-25 min',
                        'calories' => 920,
                        'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => true,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => false,
                        'is_spicy' => false,
                        'spice_level' => 1,
                        'tags' => ['Cheesy Pizza', 'Family Size'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Medium 10 Inch (6 Slices)', 'price' => 0],
                                ['name' => 'Large 12 Inch (8 Slices)', 'price' => 200.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Cheese Burst Crust', 'price' => 90.00],
                                ['name' => 'Garlic Mayo Dip Cup', 'price' => 30.00],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Kushtia Street Snacks & Fuchka',
                'slug' => 'street-snacks',
                'icon' => 'utensils',
                'tagline' => 'স্পেশাল টক-ঝাল-মিষ্টি ফুচকা, কুষ্টিয়ার স্পেশাল চটপটি ও হালিম',
                'display_order' => 5,
                'items' => [
                    [
                        'name' => 'Kushtia Special Dahi Fuchka Platter (10 Pcs)',
                        'slug' => 'kushtia-special-dahi-fuchka',
                        'description' => 'মুচমুচে ফুচকা, ভেতরে আলু-মটর ও ডিমের পুর, ওপরে মিষ্টি দই, পুদিনা পাতা, সেউ ও তেঁতুলের ঘন চাটনি।',
                        'price' => 160.00,
                        'original_price' => 190.00,
                        'rating' => 4.9,
                        'reviews_count' => 680,
                        'prep_time' => '8-12 min',
                        'calories' => 320,
                        'image' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => true,
                        'spice_level' => 2,
                        'tags' => ['Street Food', 'Dahi Fuchka', 'Crispy'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Platter (10 Pcs)', 'price' => 0],
                                ['name' => 'Jumbo Platter (20 Pcs)', 'price' => 140.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Sweet Curd & Tamarind Sauce', 'price' => 30.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Shahi Mutton Haleem with Fried Onion & Ginger',
                        'slug' => 'shahi-mutton-haleem',
                        'description' => 'বিভিন্ন রকমের ডাল ও গমের সাথে ঘণ্টার পর ঘণ্টা সিদ্ধ খাসির মাংসের ঘন সুস্বাদু শাহী হালিম। বেরেস্তা ও লেবু সহ।',
                        'price' => 220.00,
                        'original_price' => 260.00,
                        'rating' => 4.8,
                        'reviews_count' => 390,
                        'prep_time' => '10-15 min',
                        'calories' => 490,
                        'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => false,
                        'is_chef_special' => true,
                        'is_vegetarian' => false,
                        'is_spicy' => true,
                        'spice_level' => 2,
                        'tags' => ['Rich Protein', 'Mutton Haleem'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Single Bowl (350ml)', 'price' => 0],
                                ['name' => 'Family Bowl (750ml)', 'price' => 190.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Crispy Fried Beresta', 'price' => 20.00],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Drinks & Traditional Borhani',
                'slug' => 'drinks-beverages',
                'icon' => 'coffee',
                'tagline' => 'টক-ঝাল বোরহানি, কুষ্টিয়ার স্পেশাল লাচ্ছি ও কোল্ড কফি',
                'display_order' => 6,
                'items' => [
                    [
                        'name' => 'Traditional Shahi Spicy Borhani (500ml)',
                        'slug' => 'traditional-shahi-spicy-borhani',
                        'description' => 'টক দই, পুদিনা পাতা, বিট লবণ, জিরা ও সরিষা বাটার আসল স্বাদে তৈরি ঠাণ্ডা সুস্বাদু বোরহানি। হজমে অত্যন্ত উপকারী।',
                        'price' => 90.00,
                        'original_price' => 110.00,
                        'rating' => 4.9,
                        'reviews_count' => 520,
                        'prep_time' => '3-5 min',
                        'calories' => 140,
                        'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => true,
                        'spice_level' => 1,
                        'tags' => ['Digestive', 'Cold Beverage', 'Shahi Recipe'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => '500ml Bottle', 'price' => 0],
                                ['name' => '1 Litre Family Bottle', 'price' => 80.00],
                            ],
                            'toppings' => [
                                ['name' => 'Mint Boost', 'price' => 15.00],
                            ]
                        ]
                    ],
                    [
                        'name' => 'Special Sweet Sweet Lassi with Malai & Pistachio',
                        'slug' => 'special-sweet-malai-lassi',
                        'description' => 'ঘন মিষ্টি দই ও বরফে ব্লেন্ড করা লাচ্ছি, ওপরে কুষ্টিয়ার মালাই ও পেস্তা বাদামের কুচি।',
                        'price' => 110.00,
                        'original_price' => 130.00,
                        'rating' => 4.8,
                        'reviews_count' => 290,
                        'prep_time' => '5-7 min',
                        'calories' => 220,
                        'image' => 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?auto=format&fit=crop&w=800&q=80',
                        'is_featured' => false,
                        'is_popular' => true,
                        'is_chef_special' => false,
                        'is_vegetarian' => true,
                        'is_spicy' => false,
                        'spice_level' => 0,
                        'tags' => ['Refreshing', 'Sweet Malai'],
                        'customization_options' => [
                            'sizes' => [
                                ['name' => 'Regular Glass 300ml', 'price' => 0],
                                ['name' => 'Jumbo Mug 500ml', 'price' => 50.00],
                            ],
                            'toppings' => [
                                ['name' => 'Extra Malai Layer', 'price' => 25.00],
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
