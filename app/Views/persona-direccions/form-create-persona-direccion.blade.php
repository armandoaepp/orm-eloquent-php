            <form id="form-create" action="{{  route('admin.persona-direccions.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="persona_id">Persona: </label>
                    <input type="text" class="form-control @error('persona_id') is-invalid @enderror" name="persona_id" id="persona_id" value="{{ old('persona_id') }}" required placeholder="Persona">
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
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" id="direccion" value="{{ old('direccion') }}" required placeholder="Dirección">
                    @error('direccion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="referencia">Referencia: </label>
                    <input type="text" class="form-control @error('referencia') is-invalid @enderror" name="referencia" id="referencia" value="{{ old('referencia') }}" required placeholder="Referencia">
                    @error('referencia')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_principal">Es Principal: </label>
                    <input type="text" class="form-control @error('is_principal') is-invalid @enderror" name="is_principal" id="is_principal" value="{{ old('is_principal') }}" required placeholder="Es Principal">
                    @error('is_principal')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="jerarquia">Jerarquía: </label>
                    <input type="text" class="form-control @error('jerarquia') is-invalid @enderror" name="jerarquia" id="jerarquia" value="{{ old('jerarquia') }}" required placeholder="Jerarquía">
                    @error('jerarquia')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.persona-direccions') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>