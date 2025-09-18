<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\ProductCategory;
use App\Models\Product;

class FullProductSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::where('status', 1)->get();

        $categoriesSeed = [
            [
                'slug' => 'burgers',
                'name_ka' => 'ბურგერები',
                'name_en' => 'Burgers',
                'picture' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=1200&q=80',
                'products' => [
                    ['Classic Burger', 'კლასიკური ბურგერი', 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=1200&q=80', '14.90'],
                    ['Cheese Burger', 'ჩიზბურგერი', 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=1200&q=80', '16.50'],
                    ['Double Burger', 'ორმაგი ბურგერი', 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=1200&q=80', '19.90'],
                    ['Chicken Burger', 'ქათმის ბურგერი', 'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=1200&q=80', '15.90'],
                    ['BBQ Burger', 'ბარბექიუ ბურგერი', 'https://images.unsplash.com/photo-1544025162-d76694265947?w=1200&q=80', '17.90'],
                ],
            ],
            [
                'slug' => 'pizza',
                'name_ka' => 'პიცა',
                'name_en' => 'Pizza',
                'picture' => 'https://images.unsplash.com/photo-1548366086-7d497fb40426?w=1200&q=80',
                'products' => [
                    ['Margherita', 'მარგერიტა', 'https://images.unsplash.com/photo-1548366086-7d497fb40426?w=1200&q=80', '18.90'],
                    ['Pepperoni', 'პეპერონი', 'https://images.unsplash.com/photo-1542281286-9e0a16bb7366?w=1200&q=80', '22.50'],
                    ['Four Cheese', 'ოთხი ყველი', 'https://images.unsplash.com/photo-1600628421055-4d45b7ba8c6f?w=1200&q=80', '24.00'],
                    ['Veggie Pizza', 'ბოსტნეულის პიცა', 'https://images.unsplash.com/photo-1541745537413-b804d3c4f3e0?w=1200&q=80', '20.00'],
                    ['Hawaiian', 'ჰავაიური', 'https://images.unsplash.com/photo-1542382257-80dedb725088?w=1200&q=80', '21.50'],
                    ['Meat Lovers', 'ხორცეულის', 'https://images.unsplash.com/photo-1571997478779-2adcbbe9ab2f?w=1200&q=80', '25.90'],
                ],
            ],
            [
                'slug' => 'drinks',
                'name_ka' => 'სასმელები',
                'name_en' => 'Drinks',
                'picture' => 'https://images.unsplash.com/photo-1541976076758-347942db1970?w=1200&q=80',
                'products' => [
                    ['Coca-Cola 0.5L', 'კოკა-კოლა 0.5ლ', 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=1200&q=80', '3.50'],
                    ['Sprite 0.5L', 'Sprite 0.5ლ', 'https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=1200&q=80', '3.20'],
                    ['Fanta 0.5L', 'Fanta 0.5ლ', 'https://images.unsplash.com/photo-1624953587687-dc5966f6f2f1?w=1200&q=80', '3.20'],
                    ['Water 0.5L', 'წყალი 0.5ლ', 'https://images.unsplash.com/photo-1548839140-29a750a29bf8?w=1200&q=80', '1.50'],
                    ['Energy Drink', 'ენერგეტიკული', 'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=1200&q=80', '4.50'],
                    ['Coffee', 'ყავა', 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=1200&q=80', '2.80'],
                ],
            ],
            [
                'slug' => 'salads',
                'name_ka' => 'სალათები',
                'name_en' => 'Salads',
                'picture' => 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=1200&q=80',
                'products' => [
                    ['Caesar Salad', 'ცეზარის სალათი', 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=1200&q=80', '12.90'],
                    ['Greek Salad', 'ბერძნული სალათი', 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=1200&q=80', '11.50'],
                    ['Fresh Mix', 'ახალი მიქსი', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=1200&q=80', '10.90'],
                    ['Chicken Salad', 'ქათმის სალათი', 'https://images.unsplash.com/photo-1546793665-c74683f339c1?w=1200&q=80', '14.20'],
                ],
            ],
        ];

        foreach ($companies as $company) {
            $this->command->info("Seeding products for company: {$company->name_ka}");
            
            foreach ($categoriesSeed as $catSeed) {
                $cat = ProductCategory::updateOrCreate(
                    [
                        'slug' => $catSeed['slug'].'-'.$company->slug,
                        'company_id' => $company->id,
                    ],
                    [
                        'name_ka' => $catSeed['name_ka'],
                        'name_en' => $catSeed['name_en'],
                        'description_ka' => $catSeed['name_ka'].' აღწერა',
                        'description_en' => $catSeed['name_en'].' description',
                        'icon' => null,
                        'picture' => $catSeed['picture'],
                        'show_count' => 0,
                        'status' => 1,
                        'sort' => 1,
                    ]
                );

                foreach ($catSeed['products'] as [$name_en, $name_ka, $img, $price]) {
                    $slug = \Str::slug($name_en).'-'.$company->slug;
                    Product::updateOrCreate(
                        ['slug' => $slug],
                        [
                            'company_id' => $company->id,
                            'product_category_id' => $cat->id,
                            'name_ka' => $name_ka,
                            'name_en' => $name_en,
                            'description_ka' => $name_ka.' აღწერა',
                            'description_en' => $name_en.' description',
                            'old_price' => '0',
                            'price' => $price,
                            'picture' => $img,
                            'show_count' => 0,
                            'status' => 1,
                            'product_category_slug' => $cat->slug,
                        ]
                    );
                }
            }
        }

        $this->command->info('All companies now have full product catalogs!');
    }
}
