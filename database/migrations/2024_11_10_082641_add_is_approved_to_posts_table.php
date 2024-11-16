<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsApprovedToPostsTable extends Migration
{
        public function up()
    {
        if (!Schema::hasColumn('posts', 'is_approved')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->boolean('is_approved')->default(false);
            });
        }
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('is_approved');
        });
    }
}
