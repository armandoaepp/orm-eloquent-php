            <form id="form-edit" action="{{ route('admin.persona-juridicas.update',['id' => $persona_juridica->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $persona_juridica->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <input type="text" class="form-control  @error('persona_id') is-invalid @enderror" name="persona_id" id="persona_id" placeholder="Persona Id" value="{{ old('persona_id', $persona_juridica->persona_id ?? '') }}" >
                    @error('persona_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ruc">Ruc: </label>
                    <input type="text" class="form-control  @error('ruc') is-invalid @enderror" name="ruc" id="ruc" placeholder="Ruc" value="{{ old('ruc', $persona_juridica->ruc ?? '') }}" >
                    @error('ruc')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="razon_social">Razón Social: </label>
                    <input type="text" class="form-control  @error('razon_social') is-invalid @enderror" name="razon_social" id="razon_social" placeholder="Razón Social" value="{{ old('razon_social', $persona_juridica->razon_social ?? '') }}" >
                    @error('razon_social')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="nombre_comercial">Nombre Comercial: </label>
                    <input type="text" class="form-control  @error('nombre_comercial') is-invalid @enderror" name="nombre_comercial" id="nombre_comercial" placeholder="Nombre Comercial" value="{{ old('nombre_comercial', $persona_juridica->nombre_comercial ?? '') }}" >
                    @error('nombre_comercial')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="observacion">Observación: </label>
                    <input type="text" class="form-control  @error('observacion') is-invalid @enderror" name="observacion" id="observacion" placeholder="Observación" value="{{ old('observacion', $persona_juridica->observacion ?? '') }}" >
                    @error('observacion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_reg">User Id Reg: </label>
                    <input type="text" class="form-control  @error('user_id_reg') is-invalid @enderror" name="user_id_reg" id="user_id_reg" placeholder="User Id Reg" value="{{ old('user_id_reg', $persona_juridica->user_id_reg ?? '') }}" >
                    @error('user_id_reg')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_upd">User Id Upd: </label>
                    <input type="text" class="form-control  @error('user_id_upd') is-invalid @enderror" name="user_id_upd" id="user_id_upd" placeholder="User Id Upd" value="{{ old('user_id_upd', $persona_juridica->user_id_upd ?? '') }}" >
                    @error('user_id_upd')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.persona-juridicas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 