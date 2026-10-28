
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_page_settings', function (Blueprint $table) {
            $table->string('hero_primary_button_text')
                ->nullable();

            $table->string('hero_primary_button_url')
                ->nullable();

            $table->string('hero_secondary_button_text')
                ->nullable();

            $table->string('hero_secondary_button_url')
                ->nullable();

            $table->string('stat_1_value')->nullable();
            $table->string('stat_1_label')->nullable();

            $table->string('stat_2_value')->nullable();
            $table->string('stat_2_label')->nullable();

            $table->string('stat_3_value')->nullable();
            $table->string('stat_3_label')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('home_page_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_primary_button_text',
                'hero_primary_button_url',
                'hero_secondary_button_text',
                'hero_secondary_button_url',
                'stat_1_value',
                'stat_1_label',
                'stat_2_value',
                'stat_2_label',
                'stat_3_value',
                'stat_3_label',
            ]);
        });
    }
};
