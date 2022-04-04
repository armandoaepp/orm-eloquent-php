            <form id="form-edit" action="{{ route('admin.sedes.update',['id' => $sede->sede_id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $sede->sede_id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="corporacion_id">Corporacion Id: </label>
                    <select class="form-select select2-box" name="corporacion_id" id="corporacion_id" placeholder="Corporacion Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="nombre">Nombre: </label>
                    <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" id="nombre" placeholder="Nombre" value="{{ old('nombre', $sede->nombre ?? '') }}" >
                    @error('nombre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ubigeo_id">Ubigeo Id: </label>
                    <select class="form-select select2-box" name="ubigeo_id" id="ubigeo_id" placeholder="Ubigeo Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="direccion">Direccion: </label>
                    <input type="text" class="form-control  @error('direccion') is-invalid @enderror" name="direccion" id="direccion" placeholder="Direccion" value="{{ old('direccion', $sede->direccion ?? '') }}" >
                    @error('direccion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="principal">Principal: </label>
                    <input type="radio" class="form-control  @error('principal') is-invalid @enderror" name="principal" id="principal" placeholder="Principal" value="{{ old('principal', $sede->principal ?? '') }}" >
                    @error('principal')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.sedes') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 