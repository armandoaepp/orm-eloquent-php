            <form id="form-edit" action="{{ route('admin.persona-doc-identidads.update',['id' => $persona_doc_identidad->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $persona_doc_identidad->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="persona_id">Persona Id: </label>
                    <input type="text" class="form-control  @error('persona_id') is-invalid @enderror" name="persona_id" id="persona_id" placeholder="Persona Id" value="{{ old('persona_id', $persona_doc_identidad->persona_id ?? '') }}" >
                    @error('persona_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="tipo_identidad_id">Tipo Documento: </label>
                    <input type="text" class="form-control  @error('tipo_identidad_id') is-invalid @enderror" name="tipo_identidad_id" id="tipo_identidad_id" placeholder="Tipo Documento" value="{{ old('tipo_identidad_id', $persona_doc_identidad->tipo_identidad_id ?? '') }}" >
                    @error('tipo_identidad_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="num_doc">Numero Doc.: </label>
                    <input type="text" class="form-control  @error('num_doc') is-invalid @enderror" name="num_doc" id="num_doc" placeholder="Numero Doc." value="{{ old('num_doc', $persona_doc_identidad->num_doc ?? '') }}" >
                    @error('num_doc')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_principal">Es Principal: </label>
                    <input type="text" class="form-control  @error('is_principal') is-invalid @enderror" name="is_principal" id="is_principal" placeholder="Es Principal" value="{{ old('is_principal', $persona_doc_identidad->is_principal ?? '') }}" >
                    @error('is_principal')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="fecha_emision">Fecha Emisión: </label>
                    <input type="text" class="form-control  @error('fecha_emision') is-invalid @enderror" name="fecha_emision" id="fecha_emision" placeholder="Fecha Emisión" value="{{ old('fecha_emision', $persona_doc_identidad->fecha_emision ?? '') }}" >
                    @error('fecha_emision')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="fecha_caducidad">Fecha Caducidad: </label>
                    <input type="text" class="form-control  @error('fecha_caducidad') is-invalid @enderror" name="fecha_caducidad" id="fecha_caducidad" placeholder="Fecha Caducidad" value="{{ old('fecha_caducidad', $persona_doc_identidad->fecha_caducidad ?? '') }}" >
                    @error('fecha_caducidad')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2 text-center">
                  <input type="hidden" class="form-control" name="img_bd" id="img_bd" value="{{ $persona_doc_identidad->imagen }}">
                  @if(!empty($persona_doc_identidad->imagen))
                  <img src="{{ url($persona_doc_identidad->imagen) }}" class="img-fluid img-view-edit mb-2">
                  <hr>
                  @endif
                </div>
                <div class="col-12 mb-2">
                  <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input data-file-img="images" data-id="preview-images-edit" type="file" class="form-control" name="imagen" id="imagen" required placeholder="Imagen" accept="image/*" onchange="imagesPreview(this)">
                  </div>
                </div>

                <div class="col-12 mb-2">
                  <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="imagen">Nueva Imagen</label>
                      </div>
                      <input data-file-img="images" data-id="preview-images-edit" type="file" class="form-control" name="imagen" id="imagen" placeholder="Imagen" accept="image/*" onchange="imagesPreview(this)"> 
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-2">
                  <div class="preview-img" data-img-preview="preview-images-edit"></div>
                </div>

              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.persona-doc-identidads') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 