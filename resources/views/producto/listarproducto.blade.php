@extends('principal')
@section('contenido')
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Listado de Productos</h2><br/>
                       <a href="{{ url('carrito/') }}" class="btn btn-primary btn-lg btn-block" roles="button" aria-pressed="true"> Carrito de Compras </a>
                    </div>
                    
                 <div class="row">";
                             @foreach($productos as $prod)
                             <div class="col-lg-2 col-md-6 col-sm-6">
                                            <div class="product__item">
                                                <a href="#">
                                                <div class="product__item__pic set-bg">
                                                <center>
                                                    <img src="{{asset('storage/img/producto/'.$prod->imagen)}}" id="imagen1" alt="{{$prod->nombre}}" height="250" width="200" />                                   
                                                   
                                                    </center>
                                                     </div></a>
                                                          
                                                            <div class="product__item__text">
                                                                <center>
                                                                <h6>{{$prod->nombre}}</h6>
                                                                <h5>{{$prod->precio_venta}} Bs. </h5>
                                                                <a href="{{ url('agregarcarrito/'.$prod->id) }}" class="btn btn-primary btn-lg btn-block" roles="button" aria-pressed="true"> Añadir a Carrito </a>
                                                                </center>
                                                            </div>
                                                </div>
                                            </div>
                                

                                @endforeach
                            {{$productos->render()}}


                </div>
            </div>



        </main>

@endsection
