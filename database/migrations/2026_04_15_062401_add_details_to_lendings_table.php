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
        Schema::table('lendings', function (Blueprint $table) {
            $table->string('borrower_role')->after('name');
            $table->string('class')->nullable()->after('borrower_role');
            $table->date('due_date')->after('date');
            $table->longText('staff_signature')->nullable();
            $table->longText('borrower_signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lendings', function (Blueprint $table) {
            $table->dropColumn(['borrower_role', 'class', 'due_date', 'staff_signature', 'borrower_signature']);
        });
    }
};
