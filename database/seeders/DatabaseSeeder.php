<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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
            'name' => 'Cliente Teste',
            'email' => 'cliente@example.com',
        ]);

        $pecasUnicas = Category::create([
            'name' => 'Peças únicas',
            'slug' => 'pecas-unicas',
            'description' => 'Peças artesanais com identidade única, uma exemplar por vez.',
            'is_featured' => true,
        ]);

        $decoracao = Category::create([
            'name' => 'Decoração',
            'slug' => 'decoracao',
            'description' => 'Peças para casa e ambientes.',
            'is_featured' => true,
        ]);

        $presentes = Category::create([
            'name' => 'Presentes',
            'slug' => 'presentes',
            'description' => 'Peças pensadas para presentear.',
            'is_featured' => true,
        ]);

        $lavabo = Category::create([
            'parent_id' => $decoracao->id,
            'name' => 'Lavabo',
            'slug' => 'lavabo',
            'description' => 'Peças de ágata e pedra natural para lavabo.',
        ]);

        // Peça única
        $pulseira = Product::create([
            'category_id' => $pecasUnicas->id,
            'name' => 'Pulseira de ágata verde',
            'slug' => 'pulseira-de-agata-verde',
            'type' => 'unique',
            'description' => 'Peça artesanal em ágata verde, com acabamento elegante e natural. Você recebe exatamente a peça fotografada.',
            'short_description' => 'Peça única em ágata verde.',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $pulseiraVariant = ProductVariant::create([
            'product_id' => $pulseira->id,
            'name' => 'Peça única',
            'sku' => 'AG-001-UNI',
            'price' => 189.90,
            'stock_quantity' => 1,
            'weight_grams' => 40,
            'status' => 'active',
        ]);

        ProductImage::create([
            'product_id' => $pulseira->id,
            'product_variant_id' => $pulseiraVariant->id,
            'path' => 'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Pulseira de ágata verde, peça única',
            'is_primary' => true,
        ]);

        // Produto com variação
        $vaso = Product::create([
            'category_id' => $decoracao->id,
            'name' => 'Vaso de pedra natural',
            'slug' => 'vaso-de-pedra-natural',
            'type' => 'variant',
            'description' => 'Vaso em pedra natural com acabamento premium para decoração. Imagem ilustrativa; variações naturais da pedra podem ocorrer.',
            'short_description' => 'Vaso premium em pedra natural.',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $vasoMedio = ProductVariant::create([
            'product_id' => $vaso->id,
            'name' => 'Médio',
            'sku' => 'DEC-001-M',
            'price' => 320.00,
            'stock_quantity' => 3,
            'weight_grams' => 900,
            'status' => 'active',
        ]);

        ProductVariant::create([
            'product_id' => $vaso->id,
            'name' => 'Grande',
            'sku' => 'DEC-001-G',
            'price' => 420.00,
            'stock_quantity' => 3,
            'weight_grams' => 1400,
            'status' => 'active',
        ]);

        ProductImage::create([
            'product_id' => $vaso->id,
            'product_variant_id' => $vasoMedio->id,
            'path' => 'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?auto=format&fit=crop&w=800&q=80',
            'alt_text' => 'Vaso de pedra natural sobre mesa de madeira',
            'is_primary' => true,
        ]);

        // Produto padrão (imagem ilustrativa, estoque múltiplo)
        $bandeja = Product::create([
            'category_id' => $lavabo->id,
            'name' => 'Bandeja de ágata para lavabo',
            'slug' => 'bandeja-de-agata-lavabo',
            'type' => 'standard',
            'description' => 'Bandeja em corte de ágata natural, ideal para lavabo ou mesa posta. Imagem ilustrativa; variações naturais podem ocorrer.',
            'short_description' => 'Bandeja de ágata para lavabo.',
            'is_featured' => false,
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $bandeja->id,
            'name' => 'Padrão',
            'sku' => 'LAV-001',
            'price' => 149.90,
            'stock_quantity' => 12,
            'weight_grams' => 350,
            'status' => 'active',
        ]);

        // Kit / conjunto
        $kit = Product::create([
            'category_id' => $presentes->id,
            'name' => 'Kit presente ágata & madeira',
            'slug' => 'kit-presente-agata-madeira',
            'type' => 'kit',
            'description' => 'Conjunto com porta-copos de ágata e base de madeira, ideal para presentear.',
            'short_description' => 'Kit presente com ágata e madeira.',
            'is_featured' => true,
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $kit->id,
            'name' => 'Padrão',
            'sku' => 'KIT-001',
            'price' => 259.90,
            'stock_quantity' => 5,
            'weight_grams' => 1200,
            'status' => 'active',
        ]);

        // Relação "combine com" entre bandeja e kit
        $bandeja->relatedProducts()->attach($kit->id, ['type' => 'combine_with']);
        $kit->relatedProducts()->attach($bandeja->id, ['type' => 'combine_with']);
    }
}
