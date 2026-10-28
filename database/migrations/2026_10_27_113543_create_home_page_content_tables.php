
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name')->default('Fence Admin');
            $table->string('tagline')->default('Quality Fencing. Lasting Protection.');
            $table->string('hero_title')->default('A Better Fence Starts Here.');
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image_url')->nullable();
            $table->string('about_title')->default('Fencing Built Around You');
            $table->text('about_text')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });

        Schema::create('home_page_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('home_page_settings')->insert([
            'brand_name' => 'Fence Admin',
            'tagline' => 'Quality Fencing. Lasting Protection.',
            'hero_title' => 'A Better Fence Starts Here.',
            'hero_subtitle' => 'Beautiful, durable fencing solutions for your home and business. Let us help you find the right fence.',
            'hero_image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1800&q=85',
            'about_title' => 'Fencing Built Around You',
            'about_text' => 'From your first consultation to the final installation, we aim to make your fencing project simple, reliable and stress-free.',
            'phone' => '(555) 123-4567',
            'email' => 'info@example.com',
            'address' => 'Your city and service area',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_page_services')->insert([
            [
                'title' => 'Residential Fencing',
                'description' => 'Add privacy, security and curb appeal to your home.',
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=900&q=80',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Commercial Fencing',
                'description' => 'Practical fencing solutions for businesses and properties.',
                'image_url' => 'https://images.unsplash.com/photo-1511818966892-d7d671e672a2?auto=format&fit=crop&w=900&q=80',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Fence Repairs',
                'description' => 'Restore the strength, function and appearance of your fence.',
                'image_url' => 'https://images.unsplash.com/photo-1590725140246-20acdadb6ad1?auto=format&fit=crop&w=900&q=80',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_page_services');
        Schema::dropIfExists('home_page_settings');
    }
};
