<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockMovementRequest;
use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StockMovementController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->string('type')->toString();
        $search = $request->string('search')->toString();
        $movements = StockMovement::query()
            ->with('item')
            ->when(in_array($type, ['in', 'out'], true), fn (Builder $query) => $query->where('type', $type))
            ->when($search !== '', fn (Builder $query) => $query->whereHas('item', fn (Builder $itemQuery) => $itemQuery
                ->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")))
            ->latest('moved_at')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('stock-movements.index', compact('movements', 'type', 'search'));
    }

    public function create(): View
    {
        $items = Item::query()->orderBy('name')->get(['id', 'code', 'name', 'unit', 'stock']);

        return view('stock-movements.create', compact('items'));
    }

    public function store(StockMovementRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data): void {
            $item = Item::query()->lockForUpdate()->findOrFail($data['item_id']);

            if ($data['type'] === 'out' && $data['quantity'] > $item->stock) {
                throw ValidationException::withMessages([
                    'quantity' => "Stok tersedia hanya {$item->stock} {$item->unit}.",
                ]);
            }

            if ($data['type'] === 'in') {
                $item->increment('stock', $data['quantity']);
            } else {
                $item->decrement('stock', $data['quantity']);
            }

            $item->stockMovements()->create([
                'user_id' => auth()->id(),
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'moved_at' => $data['moved_at'],
                'note' => $data['note'] ?? null,
            ]);
        });

        return redirect()->route('stock-movements.index')->with('success', 'Transaksi stok berhasil dicatat.');
    }
}
