<?php
        namespace App\Http\Controllers;

        use App\Models\Product;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Storage;

        class ProductController extends Controller
        {
            public function ViewData() {
                $product = Product::get();
                return view('product.view', compact('product'));
            }

            public function AddData(){
                return view('product.add');
            }

            public function CreateData(Request $request){
                $product = new Product();
                $product->name = $request->name;
                $product->price = $request->price;
                $product->stock = $request->stock;

                // Cek apakah ada file yang diunggah, jika tidak, isi dengan string kosong
                if ($request->hasFile('foto')) {
                    $file = $request->file('foto');
                    $path = $file->store('products', 'public');
                    $product->foto = $path;
                } else {
                    $product->foto = ''; // Beri nilai default jika tidak ada file
                }

                $product->save();
                return redirect()->route('product.view');
            }


            public function EditData($id){
               $product = Product::find($id);
               return view('product.edit', compact('product'));
            }

            public function UpdateData(Request $request, $id){
                $product = Product::find($id);
                $product->name = $request->name;

                // Update foto jika ada upload baru
                if ($request->hasFile('foto')) {
                    if ($product->foto) {
                        Storage::disk('public')->delete($product->foto); // Hapus foto lama
                    }
                    $file = $request->file('foto');
                    $path = $file->store('products', 'public');
                    $product->foto = $path;
                }

                $product->price = $request->price;
                $product->stock = $request->stock;
                $product->update();

                return redirect()->route('product.view');
            }

            public function DeleteData($id){
                $product = Product::find($id);

                // Hapus foto dari storage
                if ($product->foto) {
                    Storage::disk('public')->delete($product->foto);
                }

                $product->delete();
                return redirect()->route('product.view');
            }

            public function updateStock(Request $request, $id)
        {
            // Cari produk berdasarkan ID
            $product = Product::findOrFail($id);

            // Validasi input stok agar tidak negatif
            $request->validate([
                'stock' => 'required|integer|min:0',
            ], [
                'stock.required' => 'Stok tidak boleh kosong.',
                'stock.integer' => 'Stok harus berupa angka.',
                'stock.min' => 'Stok tidak boleh kurang dari 0.',
            ]);


            // Update stok produk
            $product->stock = $request->stock;
            $product->save();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('product.view', compact('product'))->with('success', 'Stok berhasil diperbarui!');
        }
        public function editStock($id)
{
    $product = Product::findOrFail($id);
    return view('product.edit_stock', compact('product'));
}

        }

