@extends('layouts.app')

@section('content')
<div class="row align-items-center">
    <div class="col">
        <h2 class="section-title mb-0">Listado de Productos</h2>        
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#product-modal">Agregar producto</button>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="divider-line"></div>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <form action="" method="post" class="form-search">
            <div class="form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Buscar" autocomplete="off">
                <i class="fas fa-search"></i>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="row table-head">
            <div class="col-2"></div>
            <div class="col-4">Nombre del producto</div>
            <div class="col-2">Añadido el</div>
            <div class="col-2">Tipo</div>
            <div class="col-2">Precio</div>
        </div>
        <div class="row table-body">
            <div class="col">
                @foreach ($products as $product)
                <div class="row align-items-center">
                    <div class="col-2">
                        <a href="/products/view/{{ $product->external_id }}" class="btn btn-outline-primary btn-sm">Detalles</a>
                    </div>
                    <div class="col-4">
                        <span class="name truncate">{{ $product->name }}</span>
                    <span class="description truncate">{{ $product->description }}</span>
                    </div>
                    <div class="col-2">
                        {{ date("d/m/Y", strtotime($product->created_at)) }}
                    </div>
                    <div class="col-2">
                        {{ $product->type }}
                    </div>
                    <div class="col-2">
                        $ {{ $product->price }}
                    </div>
                </div>
                @endforeach
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
                <form action="{{ route('add-product') }}" method="post">
                    @csrf
                    <div class="form-group row align-items-center">
                        <label for="name" class="col-3">Nombre</label>
                        <div class="col">
                            <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="type" class="col-3">Tipo</label>
                        <div class="col">
                            <select name="type" id="type" class="form-control">
                                <option value="Tecnología">Tecnología</option>
                                <option value="Alimentos">Alimentos</option>
                                <option value="Ropa">Ropa</option>
                                <option value="Inmuebles">Inmuebles</option>
                                <option value="Decoración">Decoración</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="price" class="col-3">Precio</label>
                        <div class="col-4">
                            <input type="text" name="price" id="price" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="iva" class="col-3">IVA</label>
                        <div class="col-4">
                            <select name="iva" id="iva" class="form-control">
                                <option value="0">0 %</option>
                                <option value="0.12">12 %</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-3">Descripción</label>
                        <div class="col">
                            <textarea class="form-control" id="description" name="description" rows="3" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="size" class="col-3">Tamaños</label>
                        <div class="col">
                            <input type="text" name="size" id="size" class="form-control" autocomplete="off">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Separados por ",". Ejemplo: Grande, Mediano, Pequeño
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="color" class="col-3">Colores</label>
                        <div class="col">
                            <input type="text" name="color" id="color" class="form-control" autocomplete="off">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Separados por ",". Ejemplo: Azul, Rojo, Verde
                            </small>
                        </div>
                    </div>
                    <div class="form-group row align-items-center mb-4">
                        <label for="color" class="col-3">Expiración</label>
                        <div class="col">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="expires" name="expires">
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
@endsection