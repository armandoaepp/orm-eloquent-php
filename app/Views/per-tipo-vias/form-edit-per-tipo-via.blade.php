            <form id="form-edit" action="{{ route('admin.per-tipo-vias.update',['id' => $per_tipo_via->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $per_tipo_via->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_tv">Código: </label>
                    <input type="text" class="form-control  @error('cod_tv') is-invalid @enderror" name="cod_tv" id="cod_tv" placeholder="Código" value="{{ old('cod_tv', $per_tipo_via->cod_tv ?? '') }}" >
                    @error('cod_tv')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="abrv_via">Abreviatura: </label>
                    <input type="text" class="form-control  @error('abrv_via') is-invalid @enderror" name="abrv_via" id="abrv_via" placeholder="Abreviatura" value="{{ old('abrv_via', $per_tipo_via->abrv_via ?? '') }}" >
                    @error('abrv_via')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripción: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripción" value="{{ old('descripcion', $per_tipo_via->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.per-tipo-vias') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 