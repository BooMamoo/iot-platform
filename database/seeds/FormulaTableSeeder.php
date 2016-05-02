<?php

use Illuminate\Database\Seeder;

class FormulaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('formulas')->insert(array([
            'name' => 'TTC05',
            'formula' => 'x/15',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ],[
            'name' => 'LDR',
            'formula' => 'x/5',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]));
    }
}
