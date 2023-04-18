            <form id="form-create" action="{{  route('admin.pacientes.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sede_id">Sede: </label>
                    <input type="text" class="form-control @error('sede_id') is-invalid @enderror" name="sede_id" id="sede_id" value="{{ old('sede_id') }}" required placeholder="Sede">
                    @error('sede_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

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
                    <label for="codigo">Código: </label>
                    <input type="number" class="form-control @error('codigo') is-invalid @enderror" name="codigo" id="codigo" value="{{ old('codigo') }}" required placeholder="Código">
                    @error('codigo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="num_doc">Dni / Num Documento: </label>
                    <input type="number" class="form-control @error('num_doc') is-invalid @enderror" name="num_doc" id="num_doc" value="{{ old('num_doc') }}" required placeholder="Dni / Num Documento">
                    @error('num_doc')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="apellidos">Apellidos: </label>
                    <input type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" required placeholder="Apellidos">
                    @error('apellidos')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="nombres">Nombres: </label>
                    <input type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" id="nombres" value="{{ old('nombres') }}" required placeholder="Nombres">
                    @error('nombres')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="telefono">Teléfono: </label>
                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror" name="telefono" id="telefono" value="{{ old('telefono') }}" required placeholder="Teléfono">
                    @error('telefono')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
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
                    <label for="sexo">Sexo: </label>
                    <input type="text" class="form-control @error('sexo') is-invalid @enderror" name="sexo" id="sexo" value="{{ old('sexo') }}" required placeholder="Sexo">
                    @error('sexo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_reg">User Id Reg: </label>
                    <input type="text" class="form-control @error('user_id_reg') is-invalid @enderror" name="user_id_reg" id="user_id_reg" value="{{ old('user_id_reg') }}" required placeholder="User Id Reg">
                    @error('user_id_reg')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_upd">User Id Upd: </label>
                    <input type="text" class="form-control @error('user_id_upd') is-invalid @enderror" name="user_id_upd" id="user_id_upd" value="{{ old('user_id_upd') }}" required placeholder="User Id Upd">
                    @error('user_id_upd')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.pacientes') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>