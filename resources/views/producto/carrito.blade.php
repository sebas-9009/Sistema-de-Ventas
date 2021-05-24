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
                       <h2>Carrito de Compras</h2><br/>                     
                    </div>
                    
            <?php $valor = 0?>
            @if(session('carrito'))
            <table class="table">
                <thead class="thead-dark">               
                    <tr>
                        <th scope="col">
                            Producto
                        </th>
                        <th scope="col">
                            Precio Unitario
                        </th>
                        <th scope="col">
                            Cantidad
                        </th>
                        <th scope="col">
                            Precio Total
                        </th>
                        <th scope="col">
                            Imagen
                        </th>
                    </tr>
                </thead>
                @foreach(session('carrito') as $id => $details)
                
                
                <?php $valor += $details['precio'] * $details['cantidad']?>
                <tr>
                    <td>
                        {{  $details['nombre']    }}
                    </td>
                    <td>
                        {{   $details['precio']   }} Bs.
                    </td>
                    <td>
                        {{  $details['cantidad']    }}
                    </td>
                    <td>
                        {{     $details['precio'] * $details['cantidad']   }} Bs.
                    </td>
                    <td>
                        <img src="{{asset('storage/img/producto/'.$details['imagen'])}}" width="50" height="50"/>
                    </td>
                </tr>
                @endforeach               
                </table>
                @endif   


                    
                        


            </div>

            <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            Valor
                        </th>
                        <th scope="col">
                            IVA(13%)
                        </th>
                        <th scope="col">
                            Valor Total c./IVA
                        </th>
                    </tr>
                    <tr>
                        <td>
                        {{  $valor  }} Bs.
                        </td>
                        <td>
                        {{  $valor*0.13   }} Bs.
                        </td>
                        <td>
                        
                        {{session()->put('preciototal',$valor+$valor*0.13 )}}
                        <b>{{  $valor+$valor*0.13    }} Bs.
                        </td>
        </table>
        <div id="smart-button-container">
        <div style="text-align: center;">
        <div id="paypal-button-container"></div>
      </div>
    </div>
  <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD" data-sdk-integration-source="button-factory"></script>
  <script>
    function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'paypal',
          
        },

        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"Venta","amount":{"currency_code":"USD","value":50}}]
          });
        },

        onApprove: function(data, actions) {
          return actions.order.capture().then(function(details) {
            alert('Transaction completed by ' + details.payer.name.given_name + '!');
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>
        </main>

@endsection
