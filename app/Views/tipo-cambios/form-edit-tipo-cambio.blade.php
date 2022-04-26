            <form id="form-edit" action="{{ route('admin.tipo-cambios.update',['id' => $tipo_cambio->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $tipo_cambio->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="fecha">Fecha: </label>
                    <input type="text" class="form-control  @error('fecha') is-invalid @enderror" name="fecha" id="fecha" placeholder="Fecha" value="{{ old('fecha', $tipo_cambio->fecha ?? '') }}" >
                    @error('fecha')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="valor">Valor: </label>
                    <input type="text" class="form-control  @error('valor') is-invalid @enderror" name="valor" id="valor" placeholder="Valor" value="{{ old('valor', $tipo_cambio->valor ?? '') }}" >
                    @error('valor')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.tipo-cambios') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 