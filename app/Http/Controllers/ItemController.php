<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $categoryId = $request->integer('category_id');
        $lowStockOnly = $request->string('stock')->toString() === 'low';
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);
        $items = Item::query()
            ->with('category')
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            }))
            ->when($categoryId > 0, fn ($query) => $query->where('category_id', $categoryId))
            ->when($lowStockOnly, fn ($query) => $query->lowStock())
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('items.index', compact('items', 'categories', 'search', 'categoryId'));
    }

    public function create(): View
    {
        $item = new Item;
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('items.create', compact('item', 'categories'));
    }

    public function store(ItemRequest $request): RedirectResponse
    {
        Item::create($request->validated());

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item): View
    {
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('items.edit', compact('item', 'categories'));
    }

    public function update(ItemRequest $request, Item $item): RedirectResponse
    {
        $item->update($request->validated());

        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        if ($item->stockMovements()->exists()) {
            return back()->with('error', 'Barang yang sudah memiliki riwayat transaksi tidak dapat dihapus.');
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
