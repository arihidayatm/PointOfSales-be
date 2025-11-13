<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Carbon\Carbon;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates random orders from 2025-09-01 up to today so charts/widgets have data.
     */
    public function run(): void
    {
        $start = Carbon::create(2025, 9, 1)->startOfDay();
        $end = Carbon::now();

        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            // 0..5 orders per day
            $count = rand(0, 5);

            for ($i = 0; $i < $count; $i++) {
                $totalPrice = rand(20000, 2000000); // random total between Rp20k and Rp2M

                // create order with allowed fillable fields
                $order = Order::create([
                    'transaction_number' => 'TX' . $d->format('Ymd') . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                    'cashier_id' => 1,
                    'total_price' => $totalPrice,
                    'total_item' => rand(1, 10),
                    'payment_method' => ['cash', 'card', 'ewallet'][array_rand(['cash', 'card', 'ewallet'])],
                ]);

                // Force set created_at to the target day + random seconds so grouping by date works
                $order->timestamps = false;
                $order->created_at = $d->copy()->addSeconds(rand(3600, 86399));
                $order->updated_at = $order->created_at;
                $order->save();
                $order->timestamps = true;
            }
        }
    }
}
