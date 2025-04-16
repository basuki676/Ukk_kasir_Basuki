<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailSale;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function ViewSale()
    {
        $sale = Sale::get();
        return view('sale.view', compact('sale'));
    }

    public function AddSale()
    {
        $products = Product::all(); // Mengambil semua produk
        return view('sale.add', compact('products'));
    }

    public function CreateSalePost(Request $request)
    {
        $selectedProducts = $request->input('shop', []);

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
        }

        // Validate stock before proceeding
        foreach ($selectedProducts as $productData) {
            $data = explode(';', $productData);
            $productId = $data[0];
            $quantity = $data[3];

            $product = Product::find($productId);
            if (!$product || $product->stock < $quantity) {
                return redirect()
                    ->back()
                    ->with('error', 'Stok produk ' . $data[1] . ' tidak mencukupi!');
            }
        }

        session(['selected_products' => $selectedProducts]);

        return redirect()->route('sale.post');
    }

    public function ShowSalePost()
    {
        $selectedProductsData = session('selected_products', []);
        $selectedProducts = [];

        foreach ($selectedProductsData as $productData) {
            $data = explode(';', $productData);
            $selectedProducts[] = [
                'id' => $data[0],
                'name' => $data[1],
                'price' => $data[2],
                'quantity' => $data[3],
                'total' => $data[4],
            ];
        }

        return view('sale.post', compact('selectedProducts'));
    }

    public function Createsale(Request $request)
    {
        $totalPrice = $request->input('total');
        $totalPay = (int) filter_var($request->input('total_pay'), FILTER_SANITIZE_NUMBER_INT);
        $totalReturn = $totalPay - $totalPrice;
        $pointsEarned = floor($totalPrice * 0.01);

        // Create sale record
        $sale = new Sale();
        $sale->total_price = $totalPrice;
        $sale->total_pay = $totalPay;
        $sale->total_return = $totalReturn;
        $sale->user_id = Auth::id();
        $sale->customer_id = 0;
        $sale->poin = 0;
        $sale->total_poin = 0;

        // Jika memilih member
        if ($request->input('member') === 'Member') {
            $phone = $request->input('no_hp');

            if ($phone) {
                $customer = Customer::firstOrCreate(['no_hp' => $phone], ['name' => 'Temporary', 'point' => 0]);

                $sale->customer_id = $customer->id;
                $sale->total_poin = $customer->point + $pointsEarned;
            }
        }

        $sale->save();

        // Simpan detail produk dan kurangi stok
        $selectedProductsData = session('selected_products', []);
        foreach ($selectedProductsData as $productData) {
            $data = explode(';', $productData);

            // Create sale detail
            DetailSale::create([
                'sale_id' => $sale->id,
                'product_id' => $data[0],
                'amount' => $data[3],
                'sub_total' => $data[2] * $data[3],
            ]);

            // Reduce product stock
            $product = Product::find($data[0]);
            $product->stock -= $data[3];
            $product->save();
        }

        return $sale->customer_id !== 0 ? redirect()->route('sale.member', $sale->id) : redirect()->route('sale.invoice', $sale->id)->with('success', 'Penjualan berhasil disimpan!');
    }

    public function ViewInvoice($id)
    {
        $sale = Sale::find($id);
    
        $selectedProductsData = session('selected_products', []);
        $selectedProducts = [];
        $totalHargaAwal = 0;
    
        foreach ($selectedProductsData as $productData) {
            $data = explode(';', $productData);
            $subTotal = $data[2] * $data[3];
            $totalHargaAwal += $subTotal;
            
            $selectedProducts[] = [
                'id' => $data[0],
                'name' => $data[1],
                'price' => $data[2],
                'quantity' => $data[3],
                'total' => $subTotal,
            ];
        }
    
        // Hitung poin dari total harga awal (1%)
        $pointsEarned = floor($totalHargaAwal * 0.01);
    
        return view('sale.invoice', compact('sale', 'selectedProducts', 'totalHargaAwal', 'pointsEarned'));
    }

    public function CreateSaleMember($id)
    {
        $sale = Sale::findOrFail($id);
        $customer = $sale->customer;

        $selectedProductsData = session('selected_products', []);
        $selectedProducts = [];

        foreach ($selectedProductsData as $productData) {
            $data = explode(';', $productData);
            $selectedProducts[] = [
                'id' => $data[0],
                'name' => $data[1],
                'price' => $data[2],
                'quantity' => $data[3],
                'total' => $data[4],
            ];
        }

        // Calculate total price
        $totalPrice = 0;
        foreach ($selectedProducts as $product) {
            $totalPrice += $product['price'] * $product['quantity'];
        }

        // Calculate potential points (1% of total price)
        $potentialPoints = floor($totalPrice * 0.01);

        // Get current points if customer exists
        $currentPoints = $customer ? $customer->point : 0;

        return view('sale.member', compact('sale', 'selectedProducts', 'currentPoints', 'potentialPoints'));
    }

    public function CreateSaleMemberPost(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'points_to_use' => 'nullable|integer|min:0',
    ]);

    $sale = Sale::findOrFail($id);
    $customer = $sale->customer;

    $selectedProducts = session('selected_products', []);
    $totalPrice = array_reduce(
        $selectedProducts,
        function ($carry, $product) {
            $data = explode(';', $product);
            return $carry + $data[2] * $data[3];
        },
        0,
    );

    // Calculate points earned from ORIGINAL total price (before any discounts)
    $pointsEarned = floor($totalPrice * 0.01);

    $pointsUsed = 0;
    if ($request->has('check_poin') && $request->check_poin == 'Ya' && $customer->point > 0) {
        $pointsUsed = min($request->points_to_use, $customer->point);
        $totalPrice = max($totalPrice - $pointsUsed, 0);
    }

    // Update customer
    $customer->update([
        'name' => $request->name,
        'point' => $customer->point - $pointsUsed + $pointsEarned,
    ]);

    // Update sale
    $sale->update([
        'total_price' => $totalPrice,
        'total_return' => $sale->total_pay - $totalPrice,
        'poin' => $pointsUsed,
        'total_poin' => $customer->point,
    ]);

    return redirect()->route('sale.invoice', $sale->id)->with('success', 'Transaksi berhasil diproses!');
}
}
