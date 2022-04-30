            <form id="form-edit" action="{{ route('admin.persona-emails.update',['id' => $persona_email->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $persona_email->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <input type="text" class="form-control  @error('persona_id') is-invalid @enderror" name="persona_id" id="persona_id" placeholder="Persona Id" value="{{ old('persona_id', $persona_email->persona_id ?? '') }}" >
                    @error('persona_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email', $persona_email->email ?? '') }}" >
                    @error('email')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_principal">Es Principal: </label>
                    <input type="checkbox" class="form-control  @error('is_principal') is-invalid @enderror" name="is_principal" id="is_principal" placeholder="Es Principal" value="{{ old('is_principal', $persona_email->is_principal ?? '') }}" >
                    @error('is_principal')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_reg">User Id Reg: </label>
                    <input type="text" class="form-control  @error('user_id_reg') is-invalid @enderror" name="user_id_reg" id="user_id_reg" placeholder="User Id Reg" value="{{ old('user_id_reg', $persona_email->user_id_reg ?? '') }}" >
                    @error('user_id_reg')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_upd">User Id Upd: </label>
                    <input type="text" class="form-control  @error('user_id_upd') is-invalid @enderror" name="user_id_upd" id="user_id_upd" placeholder="User Id Upd" value="{{ old('user_id_upd', $persona_email->user_id_upd ?? '') }}" >
                    @error('user_id_upd')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.persona-emails') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 