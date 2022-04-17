            <form id="form-edit" action="{{ route('admin.productos.update',['id' => $producto->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $producto->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sede_id">Sede Id: </label>
                    <input type="text" class="form-control  @error('sede_id') is-invalid @enderror" name="sede_id" id="sede_id" placeholder="Sede Id" value="{{ old('sede_id', $producto->sede_id ?? '') }}" >
                    @error('sede_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_min">Min Código: </label>
                    <input type="text" class="form-control  @error('cod_min') is-invalid @enderror" name="cod_min" id="cod_min" placeholder="Min Código" value="{{ old('cod_min', $producto->cod_min ?? '') }}" >
                    @error('cod_min')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripción: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripción" value="{{ old('descripcion', $producto->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_lg">Código Largo: </label>
                    <input type="text" class="form-control  @error('cod_lg') is-invalid @enderror" name="cod_lg" id="cod_lg" placeholder="Código Largo" value="{{ old('cod_lg', $producto->cod_lg ?? '') }}" >
                    @error('cod_lg')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_bar">Código de Barras: </label>
                    <input type="text" class="form-control  @error('cod_bar') is-invalid @enderror" name="cod_bar" id="cod_bar" placeholder="Código de Barras" value="{{ old('cod_bar', $producto->cod_bar ?? '') }}" >
                    @error('cod_bar')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sub_categoria_id">Sub Categoria: </label>
                    <input type="text" class="form-control  @error('sub_categoria_id') is-invalid @enderror" name="sub_categoria_id" id="sub_categoria_id" placeholder="Sub Categoria" value="{{ old('sub_categoria_id', $producto->sub_categoria_id ?? '') }}" >
                    @error('sub_categoria_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="categoria_id">Categoria: </label>
                    <input type="text" class="form-control  @error('categoria_id') is-invalid @enderror" name="categoria_id" id="categoria_id" placeholder="Categoria" value="{{ old('categoria_id', $producto->categoria_id ?? '') }}" >
                    @error('categoria_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="familia_id">Familia: </label>
                    <input type="text" class="form-control  @error('familia_id') is-invalid @enderror" name="familia_id" id="familia_id" placeholder="Familia" value="{{ old('familia_id', $producto->familia_id ?? '') }}" >
                    @error('familia_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="proveedor_id">Proveedor: </label>
                    <input type="text" class="form-control  @error('proveedor_id') is-invalid @enderror" name="proveedor_id" id="proveedor_id" placeholder="Proveedor" value="{{ old('proveedor_id', $producto->proveedor_id ?? '') }}" >
                    @error('proveedor_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="modelo_id">Modelo: </label>
                    <input type="text" class="form-control  @error('modelo_id') is-invalid @enderror" name="modelo_id" id="modelo_id" placeholder="Modelo" value="{{ old('modelo_id', $producto->modelo_id ?? '') }}" >
                    @error('modelo_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="marca_id">Marca: </label>
                    <input type="text" class="form-control  @error('marca_id') is-invalid @enderror" name="marca_id" id="marca_id" placeholder="Marca" value="{{ old('marca_id', $producto->marca_id ?? '') }}" >
                    @error('marca_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="glosa">Glosa u Observación: </label>
                    <input type="text" class="form-control  @error('glosa') is-invalid @enderror" name="glosa" id="glosa" placeholder="Glosa u Observación" value="{{ old('glosa', $producto->glosa ?? '') }}" >
                    @error('glosa')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="si" value="S"  @if($producto->publicar == "S"   ) checked="checked" @endif >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="no" value="N" @if($producto->publicar == "N"  ) checked="checked" @endif  >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.productos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 