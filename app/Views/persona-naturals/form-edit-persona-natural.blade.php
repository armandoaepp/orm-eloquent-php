            <form id="form-edit" action="{{ route('admin.persona-naturals.update',['id' => $persona_natural->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $persona_natural->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <input type="hidden" class="form-control  @error('persona_id') is-invalid @enderror" name="persona_id" id="persona_id" placeholder="Persona Id" value="{{ old('persona_id', $persona_natural->persona_id ?? '') }}" >
                    @error('persona_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="tipo_identidad_id">Tipo Documento: </label>
                    <select class="form-select select2-box" name="tipo_identidad_id" id="tipo_identidad_id" placeholder="Tipo Documento">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="num_doc">Número Doc.: </label>
                    <input type="text" class="form-control  @error('num_doc') is-invalid @enderror" name="num_doc" id="num_doc" placeholder="Número Doc." value="{{ old('num_doc', $persona_natural->num_doc ?? '') }}" >
                    @error('num_doc')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ape_paterno">Apellido Paterno: </label>
                    <input type="text" class="form-control  @error('ape_paterno') is-invalid @enderror" name="ape_paterno" id="ape_paterno" placeholder="Apellido Paterno" value="{{ old('ape_paterno', $persona_natural->ape_paterno ?? '') }}" >
                    @error('ape_paterno')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ape_materno">Apellido Materno: </label>
                    <input type="text" class="form-control  @error('ape_materno') is-invalid @enderror" name="ape_materno" id="ape_materno" placeholder="Apellido Materno" value="{{ old('ape_materno', $persona_natural->ape_materno ?? '') }}" >
                    @error('ape_materno')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="nombres">Nombres: </label>
                    <input type="text" class="form-control  @error('nombres') is-invalid @enderror" name="nombres" id="nombres" placeholder="Nombres" value="{{ old('nombres', $persona_natural->nombres ?? '') }}" >
                    @error('nombres')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="full_name">Full Name: </label>
                    <input type="text" class="form-control  @error('full_name') is-invalid @enderror" name="full_name" id="full_name" placeholder="Full Name" value="{{ old('full_name', $persona_natural->full_name ?? '') }}" >
                    @error('full_name')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sexo">Sexo: </label>
                    <input type="radio" class="form-control  @error('sexo') is-invalid @enderror" name="sexo" id="sexo" placeholder="Sexo" value="{{ old('sexo', $persona_natural->sexo ?? '') }}" >
                    @error('sexo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="estado_civil_id">Estado Civil: </label>
                    <select class="form-select select2-box" name="estado_civil_id" id="estado_civil_id" placeholder="Estado Civil">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.persona-naturals') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 