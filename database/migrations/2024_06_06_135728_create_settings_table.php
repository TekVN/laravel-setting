<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $config = App::make('config');
        Schema::create($config->get('setting.stores.database.table', 'settings'), function (Blueprint $table) {
            $table->string('group')->nullable();
            $table->string('key');
            $table->longText('value')->nullable();

            $table->unique(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $config = App::make('config');
        Schema::dropIfExists($config->get('setting.stores.database.table', 'settings'));
    }
};
