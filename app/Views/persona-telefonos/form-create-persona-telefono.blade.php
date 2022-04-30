            <form id="form-create" action="{{  route('admin.persona-telefonos.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <input type="text" class="form-control @error('persona_id') is-invalid @enderror" name="persona_id" id="persona_id" value="{{ old('persona_id') }}" required placeholder="Persona Id">
                    @error('persona_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="tipo_telefono_id">Tipo Teléfono: </label>
                    <select class="form-select select2-box" name="tipo_telefono_id" id="tipo_telefono_id" placeholder="Tipo Teléfono">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="telefono">Teléfono: </label>
                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" id="telefono" value="{{ old('telefono') }}" required placeholder="Teléfono">
                    @error('telefono')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="observación">Observación: </label>
                    <input type="text" class="form-control @error('observación') is-invalid @enderror" name="observación" id="observación" value="{{ old('observación') }}" required placeholder="Observación">
                    @error('observación')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_principal">Es Principal: </label>
                    <select class="form-select select2-box" name="is_principal" id="is_principal" placeholder="Es Principal">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
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
                {{--  <a href="{{ route('admin.persona-telefonos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>