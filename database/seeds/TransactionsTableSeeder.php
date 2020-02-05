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

        $admins = DB::table('users')->where('status', 'admin')->get('id')->toArray();
        $admin_ids = Arr::pluck($admins, 'id');

        DB::table('transactions')
            ->whereIn('fk_user', $admin_ids)
            ->delete();

        DB::update("UPDATE `transactions` SET `amount`=`quantity`*`purchase_price`");

        DB::table('transactions')
            ->where('sold', false)
            ->update([
                'selling_amount'    => null,
                'selling_date'      => null
            ]);
    }
}
