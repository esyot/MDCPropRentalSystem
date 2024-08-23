<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('approval');
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('img');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('qty');
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('rentee_name')->nullable(false);
            $table->string('rentee_contact_no')->nullable(false);
            $table->string('rentee_email')->nullable(false);
            $table->date('rent_date');
            $table->time('rent_time');
            $table->date('rent_return');
            $table->time('rent_return_time');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('icon');
            $table->string('title');
            $table->string('description');
            $table->string('redirect_link');
            $table->boolean('isRead')->default(false);
            $table->timestamps(); 
         });

         Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('replied_message')->nullable(true);
            $table->text('replied_message_name')->nullable(true);
            $table->text('replied_message_type')->nullable(true);
            $table->string('sender_name');
            $table->string('receiver_name');
            $table->text('content')->nullable(true)->default('like');
            $table->text('img')->nullable(true);
            $table->boolean('isReacted')->default(false);
            $table->boolean('isRead')->default(false);
            $table->string('type')->default('like');
            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendings');
    }
};
