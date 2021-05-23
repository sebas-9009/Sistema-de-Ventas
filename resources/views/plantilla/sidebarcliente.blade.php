<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    

                    <li class="nav-title">
                        Menú
                    </li>

                   
                  
                   
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('listar')}}" onclick="event.preventDefault(); document.getElementById('listar-form').submit();"><i class="fa fa-tasks"></i>Listar Productos</a>
                        <form id="listar-form" action="{{route('listar')}}" method="GET" style="display: none;">
                            {{csrf_field()}} 
                         </form>
                    </li>
                       
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('venta')}}" onclick="event.preventDefault(); document.getElementById('venta-form').submit();"><i class="fa fa-suitcase"></i> Carrito</a>                      
                            <form id="venta-form" action="{{url('venta')}}" method="GET" style="display: none;">
                            {{csrf_field()}} 
                         </form>
                    </li>

                    
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
