<?php

use App\Model\Coin;
use Illuminate\Database\Seeder;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::create(['name'=>'Default Coin', 'amount' => 500, 'available_amount'=> 500, 'price'=>10,'is_active'=> 1]);
    }
}
