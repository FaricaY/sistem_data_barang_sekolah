<?php

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Item::create([
            'name' => 'Laptop Dell',
            'category' => 'Electronics',
            'status' => 'in',
            'condition' => 'good',
            'value' => 1200,
        ]);

        Item::create([
            'name' => 'Projector Epson',
            'category' => 'Electronics',
            'status' => 'out',
            'condition' => 'damaged',
            'value' => 800,
        ]);
    }
}
