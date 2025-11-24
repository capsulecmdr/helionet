<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    public function up(): void
    {
        // Ensure the users table exists before touching it
        if (! DB::getSchemaBuilder()->hasTable('users')) {
            return;
        }

        $systemId = config('auth.system_admin_id', 1);

        $exists = DB::table('users')->where('id', $systemId)->exists();

        if (! $exists) {
            DB::table('users')->insert([
                'id'         => $systemId,
                'name'       => 'System',
                'email'      => 'system@local',
                'password'   => Hash::make(str()->random(40)), // unknown pw
                'is_admin'   => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Most people won't want to delete System on rollback.
        // If you do, uncomment this:
        // $systemId = config('auth.system_admin_id', 1);
        // DB::table('users')->where('id', $systemId)->delete();
    }
};
