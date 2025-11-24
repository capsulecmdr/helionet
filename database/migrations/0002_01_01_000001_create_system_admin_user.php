<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    public function up(): void
    {
        // Only create if missing
        $exists = DB::table('users')->where('id', 1)->exists();

        if (! $exists) {
            DB::table('users')->insert([
                'id'         => 1,
                'name'       => 'System',
                'email'      => 'system@local',
                'password'   => Hash::make(str()->random(40)), // random unknown pw
                'is_admin'   => true,    // add if your schema uses it
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Optional: you usually NEVER want to delete the System user on rollback.
        // But if you want rollback symmetry:
        // DB::table('users')->where('id', 1)->delete();
    }
};
