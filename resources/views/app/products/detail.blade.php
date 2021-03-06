@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Detalle de Producto</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#product-modal">Editar producto</button>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div id="product-details" class="row mb-5">
    <div class="col-9 mb-4">
        <h4 class="product-name">{{ $product->name }}</h4>
        <p class="product-description mb-0">{{ $product->description }}</p>
    </div>
    <div class="col-3 mb-4">
        <span class="price-tag">Precio</span>
        <span class="price">$ {{ $product->price }}</span>
    </div>
    <div class="col-6">
        <div class="row align-items-center feature-box mr-2">
            <div class="col-8">
                <span class="feature-title mb-0">Detalles</span> 
            </div>    
            <div class="col-4 text-right">
                <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#detail-modal">Añadir</a>
            </div>
            <div class="col-12 mt-4">
                <ul>
                    @foreach ($product->details as $detail)
                    <li>{{ $detail->description }}</li>
                    @endforeach                    
                </ul>
                @if (count($product->details) == 0)
                    <p class="empty-list">(No hay detalles para este producto)</p>
                @endif
            </div>
        </div>         
    </div>
    <div class="col-6">
        <div class="row feature-box">    
            <div class="col-12">
                <span class="feature-title">Características</span>    
            </div>        
            <div class="col-4">
                <div class="feature">
                    <span class="feature-tag">IVA: </span> {{ $product->iva * 100 }} %
                </div>
            </div>
            <div class="col-8">
                <div class="feature">
                    <span class="feature-tag">Tipo: </span> {{ $product->type }}
                </div>
            </div>
            <div class="col-12">
                <div class="feature">
                    <span class="feature-tag">F. Creación: </span> {{ date("d/m/Y", strtotime($product->created_at)) }}
                </div>
            </div>
            <div class="col-12">
                <div class="feature">
                    <span class="feature-tag">F. Modificación: </span> {{ date("d/m/Y", strtotime($product->updated_at)) }}
                </div>
            </div>
            <div class="col-12">
                <div class="feature">
                    <span class="feature-tag">Tamaños: </span>
                    @if ($product->size)
                        @foreach ($product->size as $size)
                            <span class="bordered-tag">{{ $size }}</span>
                        @endforeach
                    @else
                        (Ninguno)
                    @endif
                </div>
            </div>
            <div class="col-12">
                <div class="feature">
                    <span class="feature-tag">Colores: </span>
                    @if ($product->color)
                        @foreach ($product->color as $color)
                            <span class="bordered-tag">{{ $color }}</span>
                        @endforeach
                    @else
                        (Ninguno)
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Lotes del Producto</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lot-modal">Añadir lote</button>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="row table-head">
            <div class="col-2"></div>
            <div class="col-3">{{ ($product->expires) ? 'F. Elaboración':'Añadido el' }}</div>
            <div class="col-3">{{ ($product->expires) ? 'F. Expiración':'Modificado el' }}</div>
            <div class="col-2">Cantidad</div>
            <div class="col-2">Estado</div>
        </div>
        <div class="row table-body">
            <div class="col-12">
                @foreach ($product->lots as $lot)
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="dropdown dropright">
                            <a class="btn btn-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Desactivar</a>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary btn-sm">Editar</a>
                    </div>
                    <div class="col-3">
                        {{ ($product->expires) ? date("d/m/Y", strtotime($lot->elaboration)):date("d/m/Y", strtotime($lot->created_at)) }}
                    </div>
                    <div class="col-3">
                        {{ ($product->expires) ? date("d/m/Y", strtotime($lot->expiry)):date("d/m/Y", strtotime($lot->updated_at)) }}
                    </div>
                    <div class="col-2">
                        {{ $lot->quantity }} uni.
                    </div>
                    <div class="col-2">
                        {{ ($lot->state) ? 'Activo':'Inactivo' }}
                    </div>
                </div>
                @endforeach                
            </div>
            <div class="col-12">
                @if (count($product->lots) == 0)
                <p class="empty-list">(No hay lotes para este producto)</p> 
                @endif                
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detail-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add-product-detail') }}" method="post">
                    @csrf
                    <input type="hidden" name="external" value="{{ $product->external_id }}">
                    <input type="hidden" name="product" value="{{ $product->id_product }}">

                    <div class="form-group row mb-4">
                        <label for="detail-description" class="col-3">Descripción</label>
                        <div class="col">
                            <textarea rows="3" name="description" id="detail-description" class="form-control" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Products -->
<div class="modal fade" id="product-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-tag">Productos</h6>
                <h5 class="modal-title">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit-product') }}" method="post">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="external_id" value="{{ $product->external_id }}">
                    <div class="form-group row align-items-center">
                        <label for="name" class="col-3">Nombre</label>
                        <div class="col">
                            <input type="text" name="name" id="name" class="form-control" autocomplete="off" value="{{ $product->name }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="type" class="col-3">Tipo</label>
                        <div class="col">
                            <select name="type" id="type" class="form-control">
                                <option value="Tecnología" {{ ($product->type == "Tecnología") ? 'selected':'' }}>Tecnología</option>
                                <option value="Alimentos" {{ ($product->type == "Alimentos") ? 'selected':'' }}>Alimentos</option>
                                <option value="Ropa" {{ ($product->type == "Ropa") ? 'selected':'' }}>Ropa</option>
                                <option value="Inmuebles" {{ ($product->type == "Inmuebles") ? 'selected':'' }}>Inmuebles</option>
                                <option value="Decoración" {{ ($product->type == "Decoración") ? 'selected':'' }}>Decoración</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="price" class="col-3">Precio</label>
                        <div class="col-4">
                            <input type="text" name="price" id="price" class="form-control" autocomplete="off" value="{{ $product->price }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="iva" class="col-3">IVA</label>
                        <div class="col-4">
                            <select name="iva" id="iva" class="form-control">
                                <option value="0" {{ ($product->iva == 0) ? 'selected':'' }}>0 %</option>
                                <option value="0.12" {{ ($product->iva == 0.12) ? 'selected':'' }}>12 %</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-3">Descripción</label>
                        <div class="col">
                            <textarea class="form-control" id="description" name="description" rows="3" autocomplete="off">{{ $product->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        @php
                            $size = '';
                            if ($product->size) {
                                foreach ($product->size as $item) {
                                    $size = $size . $item . ", ";
                                }
                                $size = substr($size, 0, -2);
                            }
                        @endphp
                        <label for="size" class="col-3">Tamaños</label>
                        <div class="col">
                            <input type="text" name="size" id="size" class="form-control" autocomplete="off" value="{{ $size }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Separados por ",". Ejemplo: Grande, Mediano, Pequeño
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        @php
                            $color = '';
                            if ($product->color) {
                                foreach ($product->color as $item) {
                                    $color = $color . $item . ", ";
                                }
                                $color = substr($color, 0, -2);
                            }
                        @endphp
                        <label for="color" class="col-3">Colores</label>
                        <div class="col">
                            <input type="text" name="color" id="color" class="form-control" autocomplete="off" value="{{ $color }}">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Separados por ",". Ejemplo: Azul, Rojo, Verde
                            </small>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="color" class="col-3">Expiración</label>
                        <div class="col">
                            <div class="custom-control custom-checkbox">                                
                                <input type="checkbox" class="custom-control-input" id="expires" name="expires" {{ ($product->expires == 1)? 'checked':'' }}>
                                <label class="custom-control-label" for="expires">Este producto expira</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lot -->
<div class="modal fade" id="lot-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Lote</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add-product-lot') }}" method="post">
                    @csrf
                    <input type="hidden" name="external" value="{{ $product->external_id }}">
                    <input type="hidden" name="product" value="{{ $product->id_product }}">
                    <input type="hidden" name="expires" value="{{ $product->expires }}">

                    @if ($product->expires)
                    <div class="form-group row align-items-center">
                        <label for="elaboration" class="col-3">F. elaboración</label>
                        <div class="col-9">
                            <input type="date" name="elaboration" id="elaboration" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="expiry" class="col-3">F. expiración</label>
                        <div class="col-9">
                            <input type="date" name="expiry" id="expiry" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    @endif
                    
                    <div class="form-group row align-items-center mb-4">
                        <label for="quantity" class="col-3">Cantidad</label>
                        <div class="col-9">
                            <input type="number" name="quantity" id="quantity" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                        <button type="reset" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection