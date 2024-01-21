<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
/**
* Run the migrations.
*/
public function up(): void
{
Schema::create('smoothies', function (Blueprint $table) {
$table->id();
$table->string('name');
$table->text('ingredients');
$table->string('image')->nullable();
$table->unsignedBigInteger('user_id');
$table->boolean('is_vegan')->default(false);
$table->boolean('contains_regular_milk')->default(false); // Add contains_milk field
$table->boolean('contains_oat_milk')->default(false); // Add contains_oat_milk field
$table->timestamps();

$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('smoothies');
}
};
