<?php

namespace App\Http\Controllers;

// Importamos los modelos que usaremos. 
// El Service Container de Laravel se encargará de resolver automáticamente 
// las dependencias cuando las pidamos en los métodos del controlador.
use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;

// Request es inyectado automáticamente por el Service Container.
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Muestra un listado de productos.
     * El Service Container inyecta automáticamente el objeto Request.
     */
    public function index(Request $request): View
    {
        // Iniciar la consulta cargando relaciones para evitar consultas adicionales (Eager Loading)
        $query = Product::with(['category', 'offer']);

        // Si el usuario ha enviado un término de búsqueda, filtramos por nombre
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        // Ejecutar la consulta y obtener los productos
        $products = $query->get();

        // Retornar la vista con los productos
        return view('products.index', compact('products'));
    }

    /**
     * Muestra solo los productos que tienen una oferta activa.
     */
    public function onSale(): View
    {
        // Filtrar productos cuyo offer_id no sea nulo
        $products = Product::with(['category', 'offer'])
            ->whereNotNull('offer_id')
            ->get();

        return view('products.index', compact('products'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create(): View
    {
        // Cargar todas las categorías y ofertas para mostrarlas en los select del formulario
        $categories = Category::all();
        $offers = Offer::all();

        return view('admin.products.create', compact('categories', 'offers'));
    }

    /**
     * Guarda un nuevo producto en la base de datos.
     * El Service Container inyecta el Request automáticamente.
     */
    public function store(Request $request): RedirectResponse //Request representa la petición HTTP que llega al servidor
    {
        // PASO 1: Validar todos los datos del formulario, incluyendo la imagen
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category_id' => 'required|exists:categories,id',
            'offer_id' => 'nullable|exists:offers,id',
        ], [
            // Mensajes personalizados de error
            'name.required' => 'El nombre del producto es obligatorio.',
            'name.unique' => 'Ya existe un producto con ese nombre.',
            'description.required' => 'La descripción es obligatoria.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, webp.',
            'image.max' => 'La imagen no debe superar los 2MB.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no es válida.',
            'offer_id.exists' => 'La oferta seleccionada no es válida.',
        ]);

        // PASO 2: Si se subió una imagen, procesarla y guardarla
        if ($request->hasFile('image')) {
            // Guardar la imagen en storage/app/public/products
            // Laravel genera un nombre único automáticamente
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // PASO 3: Crear el producto con los datos validados
        // AÑADIDO: Asignar tallas por defecto (S, M, L, XL) automáticamente
        $validated['sizes'] = ['S', 'M', 'L', 'XL'];
        
        Product::create($validated);

        // PASO 4: Redirigir con mensaje de éxito
        return redirect()
            ->route('admin.products.index')
            ->with('success', '¡Producto creado exitosamente!');
    }

    /**
     * Muestra un producto concreto.
     */
    public function show(string $id): View
    {
        // Validar que el ID sea numérico y mayor que 0
        if (!is_numeric($id) || $id < 1) {
            abort(404, 'ID de producto inválido');
        }

        // Buscar el producto junto con sus relaciones
        $product = Product::with(['category', 'offer'])->find($id);

        // Si no existe, mostrar error 404
        if (!$product) {
            abort(404, 'Producto no encontrado');
        }

        // Obtener la categoría asociada
        $category = $product->category;

        return view('products.show', compact('product', 'category'));
    }

    /**
     * Muestra el formulario para editar un producto.
     * Aquí el Service Container resuelve automáticamente el modelo Product
     * gracias al Route Model Binding.
     */
    public function edit(Product $product): View
    {
        // Cargar todas las categorías y ofertas para los selectores del formulario
        $categories = Category::all();
        $offers = Offer::all();
        
        return view('admin.products.edit', compact('product', 'categories', 'offers'));
    }

    /**
     * Actualiza un producto existente.
     * El Service Container inyecta tanto Request como Product.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        // PASO 1: Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric|min:0|max:999999.99',
            'category_id' => 'required|exists:categories,id',
            'offer_id' => 'nullable|exists:offers,id',
        ]);

        // PASO 2: Si se subió una nueva imagen, reemplazar la anterior
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe para no acumular archivos
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Guardar la nueva imagen y obtener su ruta
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        // PASO 3: Actualizar el producto con los datos validados
        $product->update($validated);

        // PASO 4: Redirigir con mensaje de éxito
        return redirect()
            ->route('admin.products.index')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

    /**
     * Elimina un producto.
     * El Service Container resuelve el modelo Product automáticamente.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // PASO 1: Si el producto tiene imagen, eliminarla del almacenamiento
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // PASO 2: Eliminar el producto de la base de datos
        $product->delete();

        // PASO 3: Redirigir con mensaje de éxito
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Muestra la lista de productos en el panel de administración.
     */
    public function adminIndex(): View
    {
        // Obtener productos ordenados por fecha de creación (más recientes primero)
        $products = Product::with(['category', 'offer'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }
}
