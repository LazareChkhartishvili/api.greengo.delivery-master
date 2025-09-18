<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Company;
use App\Models\ProductCategory;
use App\Models\Product;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        $categories = [
            ['slug' => 'category-1', 'name_ka' => 'კატეგორია 1', 'name_en' => 'Category 1', 'status' => 1, 'sort' => 1],
            ['slug' => 'category-2', 'name_ka' => 'კატეგორია 2', 'name_en' => 'Category 2', 'status' => 1, 'sort' => 2],
            ['slug' => 'category-3', 'name_ka' => 'კატეგორია 3', 'name_en' => 'Category 3', 'status' => 1, 'sort' => 3],
            ['slug' => 'category-4', 'name_ka' => 'კატეგორია 4', 'name_en' => 'Category 4', 'status' => 1, 'sort' => 4],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Companies
        $companies = [
            ['slug' => 'company-1', 'name_ka' => 'კომპანია 1', 'name_en' => 'Company 1', 'category_id' => 1, 'status' => 1, 'sort' => 1],
            ['slug' => 'company-2', 'name_ka' => 'კომპანია 2', 'name_en' => 'Company 2', 'category_id' => 1, 'status' => 1, 'sort' => 2],
            ['slug' => 'company-3', 'name_ka' => 'კომპანია 3', 'name_en' => 'Company 3', 'category_id' => 2, 'status' => 1, 'sort' => 3],
            ['slug' => 'company-4', 'name_ka' => 'კომპანია 4', 'name_en' => 'Company 4', 'category_id' => 2, 'status' => 1, 'sort' => 4],
        ];

        foreach ($companies as $comp) {
            Company::updateOrCreate(['slug' => $comp['slug']], $comp);
        }

        // Product Categories
        $productCategories = [
            ['slug' => 'burgers-company-1', 'company_id' => 1, 'name_ka' => 'ბურგერები', 'name_en' => 'Burgers', 'status' => 1, 'sort' => 1],
            ['slug' => 'pizza-company-1', 'company_id' => 1, 'name_ka' => 'პიცა', 'name_en' => 'Pizza', 'status' => 1, 'sort' => 2],
            ['slug' => 'drinks-company-1', 'company_id' => 1, 'name_ka' => 'სასმელები', 'name_en' => 'Drinks', 'status' => 1, 'sort' => 3],
        ];

        foreach ($productCategories as $pCat) {
            ProductCategory::updateOrCreate(['slug' => $pCat['slug']], $pCat);
        }

        // Products
        $products = [
            ['slug' => 'burger-classic', 'company_id' => 1, 'product_category_id' => 1, 'name_ka' => 'კლასიკური ბურგერი', 'name_en' => 'Classic Burger', 'price' => '14.90', 'picture' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=1200&q=80', 'status' => 1],
            ['slug' => 'cheese-burger', 'company_id' => 1, 'product_category_id' => 1, 'name_ka' => 'ჩიზბურგერი', 'name_en' => 'Cheese Burger', 'price' => '16.50', 'picture' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=1200&q=80', 'status' => 1],
            ['slug' => 'margherita-pizza', 'company_id' => 1, 'product_category_id' => 2, 'name_ka' => 'მარგერიტა', 'name_en' => 'Margherita', 'price' => '18.90', 'picture' => 'https://images.unsplash.com/photo-1548366086-7d497fb40426?w=1200&q=80', 'status' => 1],
            ['slug' => 'pepperoni-pizza', 'company_id' => 1, 'product_category_id' => 2, 'name_ka' => 'პეპერონი', 'name_en' => 'Pepperoni', 'price' => '22.50', 'picture' => 'https://images.unsplash.com/photo-1542281286-9e0a16bb7366?w=1200&q=80', 'status' => 1],
            ['slug' => 'coca-cola', 'company_id' => 1, 'product_category_id' => 3, 'name_ka' => 'კოკა-კოლა', 'name_en' => 'Coca-Cola', 'price' => '3.50', 'picture' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=1200&q=80', 'status' => 1],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(['slug' => $prod['slug']], $prod);
        }

        $this->command->info('Production data seeded successfully!');
    }
}
