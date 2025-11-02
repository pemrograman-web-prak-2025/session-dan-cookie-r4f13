<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $path = database_path('sql/data.sql');
        $sql = File::get($path);

        DB::unprepared($sql);

        $leaders = Leader::all();

        foreach ($leaders as $leader) {
            if (!str_starts_with($leader->password, '$2y$')) {
                $leader->password = Hash::make($leader->password);
                $leader->save();
            }
        }

    }
}
