            <form id="form-create" action="{{  route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sede_id">Sede Id: </label>
                    <input type="text" class="form-control @error('sede_id') is-invalid @enderror" name="sede_id" id="sede_id" value="{{ old('sede_id') }}" required placeholder="Sede Id">
                    @error('sede_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_min">Min Código: </label>
                    <input type="text" class="form-control @error('cod_min') is-invalid @enderror" name="cod_min" id="cod_min" value="{{ old('cod_min') }}" required placeholder="Min Código">
                    @error('cod_min')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripción: </label>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" required placeholder="Descripción">
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_lg">Código Largo: </label>
                    <input type="text" class="form-control @error('cod_lg') is-invalid @enderror" name="cod_lg" id="cod_lg" value="{{ old('cod_lg') }}" required placeholder="Código Largo">
                    @error('cod_lg')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_bar">Código de Barras: </label>
                    <input type="text" class="form-control @error('cod_bar') is-invalid @enderror" name="cod_bar" id="cod_bar" value="{{ old('cod_bar') }}" required placeholder="Código de Barras">
                    @error('cod_bar')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sub_categoria_id">Sub Categoria: </label>
                    <input type="text" class="form-control @error('sub_categoria_id') is-invalid @enderror" name="sub_categoria_id" id="sub_categoria_id" value="{{ old('sub_categoria_id') }}" required placeholder="Sub Categoria">
                    @error('sub_categoria_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="categoria_id">Categoria: </label>
                    <input type="text" class="form-control @error('categoria_id') is-invalid @enderror" name="categoria_id" id="categoria_id" value="{{ old('categoria_id') }}"  placeholder="Categoria">
                    @error('categoria_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="familia_id">Familia: </label>
                    <input type="text" class="form-control @error('familia_id') is-invalid @enderror" name="familia_id" id="familia_id" value="{{ old('familia_id') }}"  placeholder="Familia">
                    @error('familia_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="proveedor_id">Proveedor: </label>
                    <input type="text" class="form-control @error('proveedor_id') is-invalid @enderror" name="proveedor_id" id="proveedor_id" value="{{ old('proveedor_id') }}" required placeholder="Proveedor">
                    @error('proveedor_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="modelo_id">Modelo: </label>
                    <input type="text" class="form-control @error('modelo_id') is-invalid @enderror" name="modelo_id" id="modelo_id" value="{{ old('modelo_id') }}"  placeholder="Modelo">
                    @error('modelo_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="marca_id">Marca: </label>
                    <input type="text" class="form-control @error('marca_id') is-invalid @enderror" name="marca_id" id="marca_id" value="{{ old('marca_id') }}"  placeholder="Marca">
                    @error('marca_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="glosa">Glosa u Observación: </label>
                    <input type="text" class="form-control @error('glosa') is-invalid @enderror" name="glosa" id="glosa" value="{{ old('glosa') }}" required placeholder="Glosa u Observación">
                    @error('glosa')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="si" value="S" checked="checked">
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="no" value="N">
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.productos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>