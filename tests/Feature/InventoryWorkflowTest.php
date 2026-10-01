<?php

use App\Models\Category;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('increases stock and records an incoming movement', function () {
    $item = Item::factory()->create(['stock' => 0]);

    $this->post(route('stock-movements.store'), [
        'item_id' => $item->id,
        'type' => 'in',
        'quantity' => 12,
        'moved_at' => '2026-09-26',
        'note' => 'Restok awal',
    ])->assertRedirect(route('stock-movements.index'));

    $this->assertDatabaseHas('items', ['id' => $item->id, 'stock' => 12]);
    $this->assertDatabaseHas('stock_movements', [
        'item_id' => $item->id,
        'type' => 'in',
        'quantity' => 12,
        'note' => 'Restok awal',
    ]);
});

it('decreases stock and records an outgoing movement', function () {
    $item = Item::factory()->create(['stock' => 9]);

    $this->post(route('stock-movements.store'), [
        'item_id' => $item->id,
        'type' => 'out',
        'quantity' => 3,
        'moved_at' => '2026-09-26',
    ])->assertRedirect(route('stock-movements.index'));

    $this->assertDatabaseHas('items', ['id' => $item->id, 'stock' => 6]);
    $this->assertDatabaseHas('stock_movements', [
        'item_id' => $item->id,
        'type' => 'out',
        'quantity' => 3,
    ]);
});

it('rejects an outgoing movement that exceeds available stock', function () {
    $item = Item::factory()->create(['stock' => 3]);

    $this->from(route('stock-movements.create'))
        ->post(route('stock-movements.store'), [
            'item_id' => $item->id,
            'type' => 'out',
            'quantity' => 4,
            'moved_at' => '2026-09-26',
        ])
        ->assertSessionHasErrors('quantity');

    $this->assertDatabaseHas('items', ['id' => $item->id, 'stock' => 3]);
    $this->assertDatabaseCount('stock_movements', 0);
});

it('rejects a movement with an invalid type', function () {
    $item = Item::factory()->create();

    $this->from(route('stock-movements.create'))
        ->post(route('stock-movements.store'), [
            'item_id' => $item->id,
            'type' => 'transfer',
            'quantity' => 1,
            'moved_at' => '2026-09-26',
        ])
        ->assertSessionHasErrors('type');

    $this->assertDatabaseCount('stock_movements', 0);
});

it('creates a catalog item with zero opening stock', function () {
    $category = Category::factory()->create();

    $this->post(route('items.store'), [
        'category_id' => $category->id,
        'code' => 'BRG-TEST-01',
        'name' => 'Kertas A4',
        'unit' => 'rim',
        'min_stock' => 4,
        'description' => 'Kertas untuk kebutuhan kantor',
    ])->assertRedirect(route('items.index'));

    $this->assertDatabaseHas('items', [
        'category_id' => $category->id,
        'code' => 'BRG-TEST-01',
        'name' => 'Kertas A4',
        'stock' => 0,
        'min_stock' => 4,
    ]);
});

it('renders the dashboard and inventory screens', function () {
    $item = Item::factory()->create(['name' => 'Kertas A4', 'stock' => 2, 'min_stock' => 5]);

    $this->get(route('dashboard'))->assertOk()->assertSee('Ringkasan Inventori')->assertSee('Kertas A4');
    $this->get(route('items.index', ['stock' => 'low']))->assertOk()->assertSee('Kertas A4');
    $this->get(route('items.create'))->assertOk()->assertSee('Nama barang');
    $this->get(route('stock-movements.index'))->assertOk();
    $this->get(route('stock-movements.create'))->assertOk()->assertSee($item->code);
});

it('creates a category for inventory items', function () {
    $this->post(route('categories.store'), [
        'name' => 'Perlengkapan',
        'description' => 'Barang operasional',
    ])->assertRedirect(route('categories.index'));

    $this->assertDatabaseHas('categories', [
        'name' => 'Perlengkapan',
        'description' => 'Barang operasional',
    ]);
});
