<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create 10 Businesses
        $businesses = Business::factory(10)->create();

        // 2. Create 50 Products distributed across businesses
        $products = Product::factory(50)->recycle($businesses)->create();

        // 3. Create 20 Orders
        Order::factory(20)->create()->each(function (Order $order) use ($products) {
            // Add 1-5 random items to each order
            $orderProducts = $products->random(rand(1, 5));
            $totalAmount = 0;

            foreach ($orderProducts as $product) {
                $quantity = rand(1, 3);
                $unitPrice = $product->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                ]);

                $totalAmount += ($unitPrice * $quantity);
            }

            $order->update(['total_amount' => $totalAmount]);
        });
    }
}
