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
                        <a class="nav-link" href="{{route('carrito')}}" onclick="event.preventDefault(); document.getElementById('carrito-form').submit();"><i class="fa fa-suitcase"></i> Carrito</a>                      
                            <form id="carrito-form" action="{{route('carrito')}}" method="GET" style="display: none;">
                            {{csrf_field()}} 
                         </form>
                    </li>

                    
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
