<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCategoriesToProductsAndAddColumns extends Migration
{
    public function up()
    {
        // Rename the 'categories' table to 'products'
        Schema::rename('categories', 'products');

        // Add new columns 'price' and 'quantity' to the 'products' table
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable(); // Price column (nullable, 8 digits with 2 decimals)
            $table->integer('quantity')->nullable();    // Quantity column (nullable)
        });
    }

    public function down()
    {
        // Revert changes: rename the 'products' table back to 'categories' and remove 'price' and 'quantity' columns
        Schema::rename('products', 'categories');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['price', 'quantity']);
        });
    }
}
