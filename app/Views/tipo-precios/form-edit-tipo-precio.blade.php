            <form id="form-edit" action="{{ route('admin.tipo-precios.update',['id' => $tipo_precio->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $tipo_precio->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="tipo_moneda_id">Tipo Moneda Id: </label>
                    <input type="text" class="form-control  @error('tipo_moneda_id') is-invalid @enderror" name="tipo_moneda_id" id="tipo_moneda_id" placeholder="Tipo Moneda Id" value="{{ old('tipo_moneda_id', $tipo_precio->tipo_moneda_id ?? '') }}" >
                    @error('tipo_moneda_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripcion" value="{{ old('descripcion', $tipo_precio->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_base">Is Base: </label>
                    <input type="text" class="form-control  @error('is_base') is-invalid @enderror" name="is_base" id="is_base" placeholder="Is Base" value="{{ old('is_base', $tipo_precio->is_base ?? '') }}" >
                    @error('is_base')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.tipo-precios') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 