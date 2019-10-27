@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Listado de Pedidos</h2>        
    </div>
    <div class="col text-right">
        <a href="{{ route('new-order') }}" class="btn btn-primary btn-sm">Añadir Pedido</a>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <form action="{{ route('search-orders') }}" method="get" class="form-search">
            <div class="form-group">
                <input type="text" name="text" id="search" class="form-control icon" placeholder="Buscar" autocomplete="off" value="{{ $search }}">
                <i class="fas fa-search"></i>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="row table-head">
            <div class="col-2">Acciones</div>
            <div class="col-2">Codigo</div>
            <div class="col-4">Cliente</div>
            <div class="col-2">Añadido el</div>
            <div class="col-2">Estado</div>
        </div>
        <div class="row table-body">
            <div class="col">
                @foreach ($orders as $order)
                <div class="row align-items-center">
                    <div class="col-2">
                        @if ($order->state == "Pendiente")
                        <div class="dropdown">
                            <a class="btn btn-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>                            
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <button class="dropdown-item" data-toggle="modal" data-target="#cancel-modal" onclick="setExternal('{{ $order->external_id }}')">Cancelar</button>
                            </div>
                        </div>
                        <a href="{{  route('view-order', ["external" => $order->external_id ]) }}" class="btn btn-outline-primary btn-sm">Despachar</a>   
                        @else
                        <span style="font-style: italic;display: block; text-align:center;color: #989898;">(Solo lectura)</span>
                        @endif                        
                    </div>
                    <div class="col-2">#{{ $order->code }}</div>
                    <div class="col-4 truncate">{{ $order->client->firstname .' '. $order->client->lastname }}</div>
                    <div class="col-2">{{ date("d/m/Y", strtotime($order->created_at)) }}</div>
                    <div class="col-2"><span class="tag {{ ($order->state == "Cancelado") ? 'red':'' }}">{{ $order->state }}</span></div>
                </div>
                @endforeach
                
                @if (count($orders) == 0)
                <div class="row align-items-center">
                    <div class="col-12">
                        <p class="empty">No se han encontrado elementos para esta lista.</p>
                    </div>
                </div>
                @endif                
            </div>
        </div>
        <div class="row table-footer align-items-center">
            <div class="col-8">
                @php
                    $pages = ceil($count / 20);
                    $n_pages = $pages - $p;
                @endphp  

                @if ($pages > 1)
                    <nav aria-label="Page navigation example">                        
                        <ul class="pagination mb-0">
                            @if ($p != 1)
                            <li class="page-item prev">
                                <a class="page-link" href="{{ ($search) ? route('search-orders', ['p' => $p - 1 ]).'?text='.$search:route('orders', ['p' => $p - 1 ]) }}" aria-label="Anterior">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            
                            @if ($pages > 5)
                            <li class="page-item">
                                <a class="page-link" href="{{ ($search) ? route('search-orders', ['p' => 1 ]).'?text='.$search:route('orders', ['p' => 1 ]) }}">1</a>
                            </li>
                            <li class="page-item">
                                <span>...</span>
                            </li>
                            @endif
                            
                            @endif 

                            @if ($n_pages >= 5)
                                @for ($i = $p; $i <= $p + 4; $i++)
                                <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ ($search) ? route('search-orders', ['p' => $i ]).'?text='.$search:route('orders', ['p' => $i ]) }}">{{ $i }}</a></li>
                                @endfor                             
                            @else
                                @if ($pages > 5)
                                    @for ($i = $pages - 5; $i <= $pages; $i++)
                                    <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ ($search) ? route('search-orders', ['p' => $i ]).'?text='.$search:route('orders', ['p' => $i ]) }}">{{ $i }}</a></li>
                                    @endfor    
                                @else
                                    @for ($i = 1; $i <= $pages; $i++)
                                    <li class="page-item {{ ($i == $p) ? 'active':'' }}" {{ ($i == $p) ? 'aria-current="page"':'' }}><a class="page-link" href="{{ ($search) ? route('search-orders', ['p' => $i ]).'?text='.$search:route('orders', ['p' => $i ]) }}">{{ $i }}</a></li>
                                    @endfor 
                                @endif
                                                            
                            @endif                            
                            
                            @if ($p != $pages)

                            @if ($pages > 5 && $n_pages > 4)
                            <li class="page-item">
                                <span>...</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="{{ ($search) ? route('search-orders', ['p' => $pages ]).'?text='.$search:route('orders', ['p' => $pages ]) }}">{{ $pages }}</a>
                            </li>  
                            @endif
                            
                            <li class="page-item next">
                                <a class="page-link" href="{{ ($search) ? route('search-orders', ['p' => $p + 1 ]).'?text='.$search:route('orders', ['p' => $p + 1 ]) }}" aria-label="Siguiente">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li> 
                            @endif
                            
                        </ul>
                    </nav>         
                @endif
            </div>
            <div class="col-4">
                <p class="viewing">Viendo {{ ($p > 1) ? ((count($orders) == 20) ? ($p * 20): $count): count($orders) }} de {{ $count }} registros.</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cancel -->
<div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancelar pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="confirm-msg">¿Está seguro/a que desea realizar esta acción?</p>
                <form action="{{ route('cancel-order') }}" method="POST">
                    @csrf
                    <input type="hidden" name="external" id="external">
                    <div class="form-group text-right mt-4">
                        <button type="submit" class="btn btn-primary mr-2">Confirmar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function setExternal(external){
    $('#external').val(external);    
}
</script>
@endsection