            <form id="form-edit" action="{{ route('admin.tipo-identidads.update',['id' => $tipo_identidad->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $tipo_identidad->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_ti">Código: </label>
                    <input type="text" class="form-control  @error('cod_ti') is-invalid @enderror" name="cod_ti" id="cod_ti" placeholder="Código" value="{{ old('cod_ti', $tipo_identidad->cod_ti ?? '') }}" >
                    @error('cod_ti')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="abrv_ti">Abreviatura: </label>
                    <input type="text" class="form-control  @error('abrv_ti') is-invalid @enderror" name="abrv_ti" id="abrv_ti" placeholder="Abreviatura" value="{{ old('abrv_ti', $tipo_identidad->abrv_ti ?? '') }}" >
                    @error('abrv_ti')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripción: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripción" value="{{ old('descripcion', $tipo_identidad->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.tipo-identidads') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 