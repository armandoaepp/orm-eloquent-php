            <form id="form-edit" action="{{ route('admin.persona-direccions.update',['id' => $persona_direccion->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $persona_direccion->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="persona_id">Persona: </label>
                    <input type="text" class="form-control  @error('persona_id') is-invalid @enderror" name="persona_id" id="persona_id" placeholder="Persona" value="{{ old('persona_id', $persona_direccion->persona_id ?? '') }}" >
                    @error('persona_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="tipo_via_id">Tipo Vía: </label>
                    <select class="form-select select2-box" name="tipo_via_id" id="tipo_via_id" placeholder="Tipo Vía">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ubigeo_id">Ubigeo: </label>
                    <select class="form-select select2-box" name="ubigeo_id" id="ubigeo_id" placeholder="Ubigeo">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="direccion">Dirección: </label>
                    <input type="text" class="form-control  @error('direccion') is-invalid @enderror" name="direccion" id="direccion" placeholder="Dirección" value="{{ old('direccion', $persona_direccion->direccion ?? '') }}" >
                    @error('direccion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="referencia">Referencia: </label>
                    <input type="text" class="form-control  @error('referencia') is-invalid @enderror" name="referencia" id="referencia" placeholder="Referencia" value="{{ old('referencia', $persona_direccion->referencia ?? '') }}" >
                    @error('referencia')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_principal">Es Principal: </label>
                    <input type="text" class="form-control  @error('is_principal') is-invalid @enderror" name="is_principal" id="is_principal" placeholder="Es Principal" value="{{ old('is_principal', $persona_direccion->is_principal ?? '') }}" >
                    @error('is_principal')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="jerarquia">Jerarquía: </label>
                    <input type="text" class="form-control  @error('jerarquia') is-invalid @enderror" name="jerarquia" id="jerarquia" placeholder="Jerarquía" value="{{ old('jerarquia', $persona_direccion->jerarquia ?? '') }}" >
                    @error('jerarquia')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.persona-direccions') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 