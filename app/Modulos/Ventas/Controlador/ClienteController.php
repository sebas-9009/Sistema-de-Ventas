<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Illuminate\Support\Facades\Redirect;
use DB;

class ClienteController extends Controller
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

           /* $sql=trim($request->get('buscarTexto'));
            $clientes=DB::table('clientes')
            ->where('nombre','LIKE','%'.$sql.'%')
            ->orwhere('num_documento','LIKE','%'.$sql.'%')
            ->orderBy('id','desc')
            ->paginate(3);
            return view('cliente.index',["clientes"=>$clientes,"buscarTexto"=>$sql]);*/
            $sql=trim($request->get('buscarTexto'));
            $clientes=DB::table('users')
            ->where('nombre','LIKE','%'.$sql.'%')
            //->orwhere('num_documento','LIKE','%'.$sql.'%')
            ->where('idrol','=',4)
            ->orderBy('id','desc')
            ->paginate(3);
            return view('cliente.index',["clientes"=>$clientes,"buscarTexto"=>$sql]);

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
        $cliente= new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->save();
        return Redirect::to("cliente");
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
        $cliente= Cliente::findOrFail($request->id_cliente);
        $cliente->nombre = $request->nombre;
        $cliente->tipo_documento = $request->tipo_documento;
        $cliente->num_documento = $request->num_documento;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->direccion = $request->direccion;
        $cliente->save();
        return Redirect::to("cliente");
    }

}
