<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $category = Category::create([
            'name' => 'Peças únicas',
            'slug' => 'pecas-unicas',
            'description' => 'Peças artesanais com identidade única.',
            'is_featured' => true,
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Pulseira de ágata verde',
            'slug' => 'pulseira-de-agata-verde',
            'description' => 'Peça artesanal em ágata verde, com acabamento elegante e natural.',
            'short_description' => 'Peça única em ágata verde.',
            'price' => 189.90,
            'stock_quantity' => 1,
            'is_unique' => true,
            'is_featured' => true,
            'is_active' => true,
            'image_url' => 'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?auto=format&fit=crop&w=800&q=80',
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => 'Padrão único',
            'sku' => 'AG-001-UNI',
            'price' => 189.90,
            'stock_quantity' => 1,
            'weight_grams' => 40,
            'is_active' => true,
        ]);

        $categoryTwo = Category::create([
            'name' => 'Decoração',
            'slug' => 'decoracao',
            'description' => 'Peças para casa e ambientes.',
            'is_featured' => true,
        ]);

        $productTwo = Product::create([
            'category_id' => $categoryTwo->id,
            'name' => 'Vaso de pedra natural',
            'slug' => 'vaso-de-pedra-natural',
            'description' => 'Vaso em pedra natural com acabamento premium para decoração.',
            'short_description' => 'Vaso premium em pedra natural.',
            'price' => 320.00,
            'stock_quantity' => 6,
            'is_unique' => false,
            'is_featured' => true,
            'is_active' => true,
            'image_url' => 'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?auto=format&fit=crop&w=800&q=80',
        ]);

        ProductVariant::create([
            'product_id' => $productTwo->id,
            'name' => 'Médio',
            'sku' => 'DEC-001-M',
            'price' => 320.00,
            'stock_quantity' => 3,
            'weight_grams' => 900,
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $productTwo->id,
            'name' => 'Grande',
            'sku' => 'DEC-001-G',
            'price' => 420.00,
            'stock_quantity' => 3,
            'weight_grams' => 1400,
            'is_active' => true,
        ]);
    }
}
