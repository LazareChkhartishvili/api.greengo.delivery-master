<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\StafiloController as StafiloController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class WebCartController extends StafiloController
{
    protected function findOrCreateCart(string $token, $userId = null): Cart
    {
        $cart = Cart::where('token', $token)->first();
        if (!$cart) {
            $cart = Cart::create([
                'token' => $token,
                'user_id' => $userId,
            ]);
        }
        return $cart;
    }

    public function init(Request $request)
    {
        $token = $request->input('token') ?: Str::uuid()->toString();
        $cart = $this->findOrCreateCart($token, auth()->id());
        return $this->sendResponse(['token' => $cart->token], '200');
    }

    public function get(Request $request, string $token)
    {
        $cart = Cart::where('token', $token)->with(['items.product'])->first();
        if (!$cart) return $this->sendResponse(['items' => [], 'total_qty' => 0, 'total_price' => 0], '200');

        $items = $cart->items->map(function (CartItem $item) {
            $p = $item->product;
            $picture = $p?->picture;
            if (!empty($picture) && !str_starts_with($picture, 'http')) {
                $picture = "https://api.greengo.delivery".$picture;
            }
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'slug' => $p?->slug,
                'name_ka' => $p?->name_ka,
                'name_en' => $p?->name_en,
                'price' => $item->price ?? $p?->price,
                'qty' => $item->qty,
                'picture' => $picture,
            ];
        });

        $totalQty = $cart->items->sum('qty');
        $totalPrice = $cart->items->reduce(function ($sum, CartItem $i) {
            return $sum + ($i->qty * (float)($i->price ?? 0));
        }, 0);

        return $this->sendResponse([
            'items' => $items,
            'total_qty' => $totalQty,
            'total_price' => $totalPrice,
        ], '200');
    }

    public function add(Request $request)
    {
        $token = $request->input('token');
        $productId = (int)$request->input('product_id');
        $qty = max(1, (int)$request->input('qty', 1));

        if (!$token || !$productId) return $this->sendError('Invalid payload');

        $cart = $this->findOrCreateCart($token, auth()->id());
        $product = Product::findOrFail($productId);

        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
        if ($item) {
            $item->qty += $qty;
            if ($item->price === null) $item->price = $product->price;
            $item->save();
        } else {
            $item = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'qty' => $qty,
                'price' => $product->price,
            ]);
        }

        return $this->get($request, $cart->token);
    }

    public function update(Request $request)
    {
        $token = $request->input('token');
        $productId = (int)$request->input('product_id');
        $qty = (int)$request->input('qty');
        if (!$token || !$productId || $qty < 0) return $this->sendError('Invalid payload');

        $cart = Cart::where('token', $token)->firstOrFail();
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
        if (!$item) return $this->sendError('Item not found');

        if ($qty === 0) {
            $item->delete();
        } else {
            $item->qty = $qty;
            $item->save();
        }

        return $this->get($request, $cart->token);
    }

    public function remove(Request $request)
    {
        $token = $request->input('token');
        $productId = (int)$request->input('product_id');
        if (!$token || !$productId) return $this->sendError('Invalid payload');

        $cart = Cart::where('token', $token)->firstOrFail();
        CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->delete();
        return $this->get($request, $cart->token);
    }

    public function clear(Request $request)
    {
        $token = $request->input('token');
        if (!$token) return $this->sendError('Invalid payload');
        $cart = Cart::where('token', $token)->first();
        if ($cart) {
            CartItem::where('cart_id', $cart->id)->delete();
        }
        return $this->sendResponse(['items' => [], 'total_qty' => 0, 'total_price' => 0], '200');
    }
}


