<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Venta;
use App\DetalleVenta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use DB;

class ProductoController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if($request){

            $sql=trim($request->get('buscarTexto'));
            $productos=DB::table('productos as p')
            ->join('categorias as c','p.idcategoria','=','c.id')
            ->select('p.id','p.idcategoria','p.nombre','p.precio_venta','p.codigo','p.stock','p.imagen','p.condicion','c.nombre as categoria')
            ->where('p.nombre','LIKE','%'.$sql.'%')
            ->orwhere('p.codigo','LIKE','%'.$sql.'%')
            ->orderBy('p.id','desc')
            ->paginate(3);
           
            /*listar las categorias en ventana modal*/
            $categorias=DB::table('categorias')
            ->select('id','nombre','descripcion')
            ->where('condicion','=','1')->get(); 
 
            return view('producto.index',["productos"=>$productos,"categorias"=>$categorias,"buscarTexto"=>$sql]);
     
            //return $productos;
        }
       
    }


    public function listar(Request $request)
    {
        if($request){

        $sql='';
        $productos=DB::table('productos as p')
        ->join('categorias as c','p.idcategoria','=','c.id')
        ->select('p.id','p.idcategoria','p.nombre','p.precio_venta','p.codigo','p.stock','p.imagen','p.condicion','c.nombre as categoria')
        ->where('p.nombre','LIKE','%'.$sql.'%')
        ->orwhere('p.codigo','LIKE','%'.$sql.'%')
        ->orderBy('p.id','desc')
        ->paginate(20);
       
        /*listar las categorias en ventana modal*/
        $categorias=DB::table('categorias')
        ->select('id','nombre','descripcion')
        ->where('condicion','=','1')->get(); 

        return view('producto.listarproducto',["productos"=>$productos,"categorias"=>$categorias,"buscarTexto"=>$sql]);
 
        }
       
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $producto= new Producto();
        $producto->idcategoria = $request->id;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = '0';
        $producto->condicion = '1';

        //Handle File Upload
        if($request->hasFile('imagen')){

        //Get filename with the extension
        $filenamewithExt = $request->file('imagen')->getClientOriginalName();
        
        //Get just filename
        $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
        
        //Get just ext
        $extension = $request->file('imagen')->guessClientExtension();
        
        //FileName to store
        $fileNameToStore = time().'.'.$extension;
        
        //Upload Image
        $path = $request->file('imagen')->storeAs('public/img/producto',$fileNameToStore);

       
        } else{

            $fileNameToStore="noimagen.jpg";
        }
        
        $producto->imagen=$fileNameToStore;


        $producto->save();
        return Redirect::to("producto");
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $producto= Producto::findOrFail($request->id_producto);
        $producto->idcategoria = $request->id;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->stock = $request->stock;
        $producto->condicion = '1';

        //Handle File Upload
       
        if($request->hasFile('imagen')){

            /*si la imagen que subes es distinta a la que está por defecto 
            entonces eliminaría la imagen anterior, eso es para evitar 
            acumular imagenes en el servidor*/ 
          if($producto->imagen != 'noimagen.jpg'){ 
            Storage::delete('public/img/producto/'.$producto->imagen);
          }

         
            //Get filename with the extension
          $filenamewithExt = $request->file('imagen')->getClientOriginalName();
          
          //Get just filename
          $filename = pathinfo($filenamewithExt,PATHINFO_FILENAME);
          
          //Get just ext
          $extension = $request->file('imagen')->guessClientExtension();
          
          //FileName to store
          $fileNameToStore = time().'.'.$extension;
          
          //Upload Image
          $path = $request->file('imagen')->storeAs('public/img/producto',$fileNameToStore);
          
           
           
        } else {
            
            $fileNameToStore = $producto->imagen; 
        }

         $producto->imagen=$fileNameToStore;
 
        $producto->save();
        return Redirect::to("producto");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // 
            $producto= Producto::findOrFail($request->id_producto);

            if($producto->condicion=="1"){
                
                $producto->condicion= '0';
                $producto->save();
                return Redirect::to("producto");
        
            } else{

                $producto->condicion= '1';
                $producto->save();
                return Redirect::to("producto");

            }
    }

       public function listarPdf(){


            $productos = Producto::join('categorias','productos.idcategoria','=','categorias.id')
            ->select('productos.id','productos.idcategoria','productos.codigo','productos.nombre','categorias.nombre as nombre_categoria','productos.stock','productos.condicion')
            ->orderBy('productos.nombre', 'desc')->get(); 


            $cont=Producto::count();

            $pdf= \PDF::loadView('pdf.productospdf',['productos'=>$productos,'cont'=>$cont]);
            return $pdf->download('productos.pdf');
          
    }
    public function carrito()
    {
        return view('producto.carrito');
    }
    public function agregarCarrito($id)
    {
        // Esta seria la logica para agregar el producto
        $producto = Producto::find($id);
        $carrito = session()->get('carrito');

        // Si el carrito esta vacio, este seria el primer producto
        if(!$carrito){
            $carrito = [
                $id => [
                    "id" => $producto->id,
                    "nombre" => $producto->nombre,
                    "cantidad" => 1,
                    "precio" => $producto->precio_venta,
                    "id" => $producto->id,
                    "imagen" => $producto->imagen

                ]
                ];
                session()->put('carrito',$carrito);
                return redirect()->back()->with('message','Producto agregado al carrito exitosamente!');
        }
        // Si el carrito no esta vacio, entonces verificar si el producto existe, incrementar la cantidad
        if(isset($carrito[$id])){
            $carrito[$id]['cantidad']++;
            session()->put('carrito',$carrito);
            return redirect()->back()->with('message','Producto agregado al carrito exitosamente!');
        }

        // Si el item no existe en el carrito, entonces agregar al carrito con cantidad = 1
        $carrito[$id] = [
            "id" => $producto->id,
            "nombre" => $producto->nombre,
            "cantidad" => 1,
            "precio" => $producto->precio_venta,
            "id" => $producto->id,
            "imagen" => $producto->imagen
        ];
        session()->put('carrito',$carrito);
        return redirect()->back()->with('message','Producto agregado al carrito exitosamente!');
    }


    public function store1(Request $request){
        try{
            $carrito = session()->get('carrito');
            $precio_total =session()->get('preciototal');

            //generador de numero de ventas
            $caracteres = '0123456789';
            $caractereslong = strlen($caracteres);
            $numeroventa = '';
            for($i = 0; $i < 6; $i++) 
            $numeroventa .= $caracteres[rand(0, $caractereslong - 1)];
            //---------------------------------

            DB::beginTransaction();
            $mytime= Carbon::now('America/Costa_Rica');

            $venta = new Venta();
            $venta->idcliente = \Auth::user()->id;
            $venta->idusuario = \Auth::user()->id;
            $venta->tipo_identificacion ='NIT';
            $venta->num_venta = $numeroventa;
            $venta->fecha_venta = $mytime->toDateString();
            $venta->impuesto = "0.13";
            $venta->total = $precio_total;
            $venta->estado = 'Registrado';
            $venta->save();

           
           
           
           //Recorro todos los elementos

            foreach(session('carrito') as $id => $details)
            {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                $detalle->idproducto = $details['id'];
                $detalle->cantidad = $details['cantidad'];
                $detalle->precio = $details['precio'];
                $detalle->descuento = '0';           
                $detalle->save();
            }

            
            
                
                
            DB::commit();

        } catch(Exception $e){
            
            DB::rollBack();
        }

        return redirect()->back()->with('success','Compra exitosa');
    }
    public function updateCart(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('carrito');
            $cart[$request->id]["cantidad"] = $request->quantity;
            session()->put('carrito', $cart);
            session()->flash('success', 'Carrito actualizado correctamente');
        }
    }
    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('carrito');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('carrito', $cart);
            }
            session()->flash('success', 'Producto quitado satisfactoriamente');
        }
    }
}

/*lider el loco*/
