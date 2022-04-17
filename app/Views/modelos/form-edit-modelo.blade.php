            <form id="form-edit" action="{{ route('admin.modelos.update',['id' => $modelo->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $modelo->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="marca_id">Marca Id: </label>
                    <textarea class="form-control ckeditor  @error('marca_id') is-invalid @enderror" name="marca_id" id="marca_id" placeholder="Marca Id" cols="30" rows="6">{{ $modelo->marca_id }}</textarea>
                    @error('marca_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_mod">Código: </label>
                    <input type="text" class="form-control  @error('cod_mod') is-invalid @enderror" name="cod_mod" id="cod_mod" placeholder="Código" value="{{ old('cod_mod', $modelo->cod_mod ?? '') }}" >
                    @error('cod_mod')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripcipón: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripcipón" value="{{ old('descripcion', $modelo->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="glosa">Glosa u Observación: </label>
                    <input type="text" class="form-control  @error('glosa') is-invalid @enderror" name="glosa" id="glosa" placeholder="Glosa u Observación" value="{{ old('glosa', $modelo->glosa ?? '') }}" >
                    @error('glosa')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="si" value="S"  @if($modelo->publicar == "S"   ) checked="checked" @endif >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="no" value="N" @if($modelo->publicar == "N"  ) checked="checked" @endif  >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.modelos') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 