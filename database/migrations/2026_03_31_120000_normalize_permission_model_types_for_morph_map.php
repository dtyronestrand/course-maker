<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $legacyType = User::class;
        $morphAlias = (new User())->getMorphClass();

        if (Schema::hasTable('model_has_roles')) {
            DB::table('model_has_roles')
                ->where('model_type', $legacyType)
                ->update(['model_type' => $morphAlias]);
        }

        if (Schema::hasTable('model_has_permissions')) {
            DB::table('model_has_permissions')
                ->where('model_type', $legacyType)
                ->update(['model_type' => $morphAlias]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $legacyType = User::class;
        $morphAlias = (new User())->getMorphClass();

        if (Schema::hasTable('model_has_roles')) {
            DB::table('model_has_roles')
                ->where('model_type', $morphAlias)
                ->update(['model_type' => $legacyType]);
        }

        if (Schema::hasTable('model_has_permissions')) {
            DB::table('model_has_permissions')
                ->where('model_type', $morphAlias)
                ->update(['model_type' => $legacyType]);
        }
    }
};
