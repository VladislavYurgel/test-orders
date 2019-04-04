<?php

use Illuminate\Database\Seeder;
use App\Models\Good;
use Tests\TestConstants;

class GoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Good::class, 10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('goods')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        foreach (TestConstants::getGoodsData() as $good) {
            Good::forceCreate($good);
        }
    }
}
