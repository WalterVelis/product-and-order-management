<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProductoRequest;
use App\Product;
use App\Category;
use App\Oferta;
use Carbon\Carbon;
use DB;

class StoreController extends Controller
{
     public function __construct()
    {

    }
    
    public function index(Request $request)
    {
        if ($request)
        {

            $productos=DB::table('producto as p')
            ->join('categoria as c','c.idcategoria','=','p.idcategoria')
            ->select('p.idproducto','p.codigo','p.nombre','p.descripcion','p.detalles','p.foto','p.precio','p.estado','c.nombre as categoria','c.idcategoria')
            ->where('p.estado','=','1')
            ->where('c.estado','=','1')
            ->orderBy('p.idcategoria','desc')
            ->paginate(9);

            $ofertas=DB::table('oferta as of')
            ->select('of.idoferta','of.idproducto','of.descripcion','of.descuento','of.estado')
            ->where('of.estado','=','1')
            ->get();

            $categorias=DB::table('categoria as c')
            ->select('c.idcategoria','c.nombre as categoria')
            ->where('c.estado','=','1')
            ->get();

            $paginacion = 9;
            $nombreCategoria = 'Productos';

            if (request()->ordenar == 'low_high') {
                $productos = Product::orderBy('precio', 'asc')->paginate($paginacion);
            } elseif (request()->ordenar == 'high_low') {
                $productos = Product::orderBy('precio', 'desc')->paginate($paginacion);
            } else {
                $productos = Product::where('estado','=','1')->paginate($paginacion);
            }

            return view('store.store_view')->with([
                'productos' => $productos,
                'categorias' => $categorias,
                'ofertas' => $ofertas,
                'nombreCategoria' => $nombreCategoria,
            ]);
        } 
    
    } 

   public function mostrarCategoria($id)
   {
       $productos=DB::table('producto as p')
       ->join('categoria as c','c.idcategoria','=','p.idcategoria')
       ->select('p.idproducto','p.codigo','p.nombre','p.descripcion','p.detalles','p.foto','p.precio','p.estado','c.nombre','c.idcategoria as categoria') 
       ->where('c.idcategoria','=',$id)
       ->where('p.estado','=','1')
       ->orderBy('c.idcategoria','desc')
       ->paginate(9);

       $categorias=DB::table('categoria as c')
       ->select('c.idcategoria','c.nombre as categoria')
       ->where('c.estado','=','1')
       ->get();

       $ofertas=DB::table('oferta as of')
       ->select('of.idoferta','of.idproducto','of.descripcion','of.descuento','of.estado')
       ->where('of.estado','=','1')
       ->get();

       $nombreCategoria = optional($categorias->where('idcategoria','=',$id)->first())->categoria;

       return view('store.store_view')->with([
           'productos' => $productos,
           'categorias' => $categorias,
           'ofertas' => $ofertas,
           'nombreCategoria' => $nombreCategoria,
       ]);
          
   }

   public function show($id)
   {
       $producto = Product::where('idproducto', $id)->firstOrFail();
       $mightAlsoLike = Product::where('idproducto', '!=', $id)->mightAlsoLike()->get();
       $oferta = Oferta::where('idproducto', $id)->firstOrFail();

       $descuento=($oferta->descuento)/100;
       $oferta->descuento=$producto->precio-($producto->precio*$descuento);

         return view('store.product')->with([
           'producto' => $producto,
           'oferta' => $oferta,
           'mightAlsoLike' => $mightAlsoLike,
       ]);
   }

   public function mostraroferta()
   {
       
       $productos=DB::table('producto as p')
       ->join('categoria as c','c.idcategoria','=','p.idcategoria')
       ->join('oferta as of','of.idproducto','=','p.idproducto')
       ->select('p.idproducto','p.codigo','p.nombre','p.descripcion','p.detalles','p.foto','p.precio','p.estado','c.nombre as categoria','c.idcategoria','of.descuento','of.idproducto as oferta')
       ->where('of.estado','=','1')
       ->where('p.estado','=','1')
       ->orderBy('c.idcategoria','desc')
       ->paginate(9);

        $categorias=DB::table('categoria as c')
        ->select('c.idcategoria','c.nombre as categoria')
        ->where('c.estado','=','1')
        ->get();

        $nombreCategoria = 'Ofertas';

        return view('store.oferta')->with([
            'productos' => $productos,
            'categorias' => $categorias,
            'nombreCategoria' => $nombreCategoria,
        ]);
       
   }
}
