            <form id="form-edit" action="{{ route('admin.personas.update',['id' => $persona->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $persona->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sede_id">Sede: </label>
                    <input type="text" class="form-control  @error('sede_id') is-invalid @enderror" name="sede_id" id="sede_id" placeholder="Sede" value="{{ old('sede_id', $persona->sede_id ?? '') }}" >
                    @error('sede_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="per_nombre">Nombre: </label>
                    <input type="text" class="form-control  @error('per_nombre') is-invalid @enderror" name="per_nombre" id="per_nombre" placeholder="Nombre" value="{{ old('per_nombre', $persona->per_nombre ?? '') }}" >
                    @error('per_nombre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="per_apellidos">Apellidos: </label>
                    <input type="text" class="form-control  @error('per_apellidos') is-invalid @enderror" name="per_apellidos" id="per_apellidos" placeholder="Apellidos" value="{{ old('per_apellidos', $persona->per_apellidos ?? '') }}" >
                    @error('per_apellidos')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="fecha_nac">Fecha Nac.: </label>
                    <input type="text" class="form-control  @error('fecha_nac') is-invalid @enderror" name="fecha_nac" id="fecha_nac" placeholder="Fecha Nac." value="{{ old('fecha_nac', $persona->fecha_nac ?? '') }}" >
                    @error('fecha_nac')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="per_tipo">Tipo: </label>
                    <input type="text" class="form-control  @error('per_tipo') is-invalid @enderror" name="per_tipo" id="per_tipo" placeholder="Tipo" value="{{ old('per_tipo', $persona->per_tipo ?? '') }}" >
                    @error('per_tipo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_reg">User Id Reg: </label>
                    <input type="text" class="form-control  @error('user_id_reg') is-invalid @enderror" name="user_id_reg" id="user_id_reg" placeholder="User Id Reg" value="{{ old('user_id_reg', $persona->user_id_reg ?? '') }}" >
                    @error('user_id_reg')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_upd">User Id Upd: </label>
                    <input type="text" class="form-control  @error('user_id_upd') is-invalid @enderror" name="user_id_upd" id="user_id_upd" placeholder="User Id Upd" value="{{ old('user_id_upd', $persona->user_id_upd ?? '') }}" >
                    @error('user_id_upd')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.personas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 