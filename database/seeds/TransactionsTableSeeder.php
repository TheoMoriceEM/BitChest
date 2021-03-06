<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Transaction;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Transaction::class, 200)->create();

        // Delete admins' transactions
        $admins = DB::table('users')->where('status', 'admin')->get('id')->toArray();
        $admin_ids = Arr::pluck($admins, 'id');

        DB::table('transactions')
            ->whereIn('user_id', $admin_ids)
            ->delete();

        // Set amount depending on quantity and purchase price defined previously by the factory
        DB::update("UPDATE `transactions` SET `amount`=`quantity`*`purchase_price`");

        // Set selling amount depending on quantity and selling price defined previously by the factory
        DB::update("UPDATE `transactions` SET `selling_amount`=`quantity`*`selling_price` WHERE `sold`=1");

        // Set selling price and date to null if not sold
        DB::table('transactions')
            ->where('sold', false)
            ->update([
                'selling_price'    => null,
                'selling_date'      => null
            ]);
    }
}
