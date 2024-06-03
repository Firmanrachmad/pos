<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableForNullifyCategoryId extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['category_id']);

            // Make the category_id column nullable
            $table->unsignedBigInteger('category_id')->nullable()->change();

            // Add the foreign key constraint with onDelete('set null')
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key constraint with onDelete('set null')
            $table->dropForeign(['category_id']);

            // Make the category_id column not nullable
            $table->unsignedBigInteger('category_id')->nullable(false)->change();

            // Add the original foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }
}
