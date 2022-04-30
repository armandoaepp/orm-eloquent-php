            <form id="form-edit" action="{{ route('admin.persona-imagens.update',['id' => $persona_imagen->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $persona_imagen->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <input type="text" class="form-control  @error('persona_id') is-invalid @enderror" name="persona_id" id="persona_id" placeholder="Persona Id" value="{{ old('persona_id', $persona_imagen->persona_id ?? '') }}" >
                    @error('persona_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="tipo">Tipo: </label>
                    <input type="text" class="form-control  @error('tipo') is-invalid @enderror" name="tipo" id="tipo" placeholder="Tipo" value="{{ old('tipo', $persona_imagen->tipo ?? '') }}" >
                    @error('tipo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_principal">Es Principal: </label>
                    <input type="text" class="form-control  @error('is_principal') is-invalid @enderror" name="is_principal" id="is_principal" placeholder="Es Principal" value="{{ old('is_principal', $persona_imagen->is_principal ?? '') }}" >
                    @error('is_principal')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="jerarquia">Jerarquía: </label>
                    <input type="text" class="form-control  @error('jerarquia') is-invalid @enderror" name="jerarquia" id="jerarquia" placeholder="Jerarquía" value="{{ old('jerarquia', $persona_imagen->jerarquia ?? '') }}" >
                    @error('jerarquia')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.persona-imagens') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 