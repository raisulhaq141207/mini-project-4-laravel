<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /** Daftar produk (+ pencarian & filter kategori). */
    public function index(Request $request)
    {
        $products = Product::with(['category', 'supplier'])
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$s}%")->orWhere('sku', 'like', "%{$s}%")))
            ->when($request->category_id, fn ($q, $id) => $q->where('category_id', $id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /** Langkah 1 alur demo: membuka form. */
    public function create()
    {
        return view('products.create', $this->formData());
    }

    /** Langkah 2-4 alur demo: validasi -> simpan -> redirect. */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $product = Product::create($validated);

        return redirect()
            ->route('products.show', $product)
            ->with('success', "Produk \"{$product->name}\" berhasil ditambahkan.");
    }

    /** Langkah 5 alur demo: menampilkan data. */
    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', $this->formData() + ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->rules($product), $this->messages());

        $product->update($validated);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    private function formData(): array
    {
        return [
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
        ];
    }

    private function rules(?Product $product = null): array
    {
        return [
            'sku' => ['required', 'string', 'max:30', Rule::unique('products', 'sku')->ignore($product)],
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    private function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute sudah digunakan.',
            'numeric' => ':attribute harus berupa angka.',
            'integer' => ':attribute harus berupa bilangan bulat.',
            'min' => ':attribute tidak boleh kurang dari :min.',
            'exists' => ':attribute yang dipilih tidak valid.',
            'max' => ':attribute maksimal :max karakter.',
        ];
    }
}
