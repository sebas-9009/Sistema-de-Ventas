@extends('principal')
@section('contenido')
<main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
            </ol>
            <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <script>alertify.success('Fue exitoso!');</script>

            <script>
                $(document).ready(function () {

                    $('.increment-btn').click(function (e) {
                        e.preventDefault();
                        var incre_value = $(this).parents('.quantity').find('.qty-input').val();
                        var value = parseInt(incre_value, 10);
                        value = isNaN(value) ? 0 : value;
                        if(value<10){
                            value++;
                            $(this).parents('.quantity').find('.qty-input').val(value);
                        }

                    });

                    $('.decrement-btn').click(function (e) {
                        e.preventDefault();
                        var decre_value = $(this).parents('.quantity').find('.qty-input').val();
                        var value = parseInt(decre_value, 10);
                        value = isNaN(value) ? 0 : value;
                        if(value>1){
                            value--;
                            $(this).parents('.quantity').find('.qty-input').val(value);
                        }
                    });
                    $(".update-cart").click(function (e) {
                        e.preventDefault();
                        var ele = $(this);
                            $.ajax({
                            url: '{{ url('update-cart') }}',
                            method: "patch",
                            data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".qty-input").val()},
                            success: function (response) {
                                window.location.reload();
                            }
                            });
                        });
                    $(".remove-from-cart").click(function (e) {
                        e.preventDefault();
                        var ele = $(this);
                        if(confirm("Estas seguro que quieres eliminar del carrito?")) {
                            $.ajax({
                                url: '{{ url('remove-from-cart') }}',
                                method: "DELETE",
                                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                                success: function (response) {
                                    window.location.reload();
                                }
                            });
                        }
                    });
            });

            </script>

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                       <h2>Carrito de Compras</h2><br/>                     
                    </div>
          <form action="#" method="POST">
            {{csrf_field()}}
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
                        <th scope="col">
                            Accion
                        </th>
                    </tr>
                </thead>
                @foreach(session('carrito') as $id => $details)
                
                
                <?php $valor += $details['precio'] * $details['cantidad']?>
                <tr class="cartpage">
                    <td>
                        {{  $details['nombre']    }}
                    </td>
                    <td>
                        {{   $details['precio']   }} Bs.
                    </td>
                    <td class="cart-product-quantity" width="140px">
                        <div class="input-group quantity">
                            <div class="input-group-prepend decrement-btn changeQuantity" style="cursor: pointer">
                                <span class="input-group-text">-</span>
                            </div>
                                <input type="text" class="qty-input form-control" maxlength="2" max="10" value="{{   $details['cantidad']   }}">
                            <div class="input-group-append increment-btn changeQuantity" style="cursor: pointer">
                                <span class="input-group-text">+</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{     $details['precio'] * $details['cantidad']   }} Bs.
                    </td>
                    <td>
                        <img src="{{asset('storage/img/producto/'.$details['imagen'])}}" width="50" height="50"/>
                    </td>
                    <td class="actions" data-th="">
                        <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
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
        
        <input  type="submit" class="btn btn-primary btn-lg btn-block" roles="button" aria-pressed="true" value="Pagar"> 
        
        </form>
        


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
