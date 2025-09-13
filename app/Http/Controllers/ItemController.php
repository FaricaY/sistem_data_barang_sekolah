<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{

public function data()
{
    $user = \Illuminate\Support\Facades\Auth::user();

    $items = [
        ['id' => 1, 'name' => 'Laptop', 'value' => 1200, 'stock' => 5],
        ['id' => 2, 'name' => 'Projector', 'value' => 800, 'stock' => 2],
        ['id' => 3, 'name' => 'Mouse', 'value' => 25, 'stock' => 50],
    ];

    return view('data', compact('user', 'items'));
}
}