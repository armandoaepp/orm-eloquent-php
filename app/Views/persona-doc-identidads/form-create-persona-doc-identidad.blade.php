            <form id="form-create" action="{{  route('admin.persona-doc-identidads.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="tipo_identidad_id">Tipo Documento: </label>
                    <input type="text" class="form-control @error('tipo_identidad_id') is-invalid @enderror" name="tipo_identidad_id" id="tipo_identidad_id" value="{{ old('tipo_identidad_id') }}" required placeholder="Tipo Documento">
                    @error('tipo_identidad_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="num_doc">Numero Doc.: </label>
                    <input type="text" class="form-control @error('num_doc') is-invalid @enderror" name="num_doc" id="num_doc" value="{{ old('num_doc') }}" required placeholder="Numero Doc.">
                    @error('num_doc')
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
                    <label for="fecha_emision">Fecha Emisión: </label>
                    <input type="text" class="form-control @error('fecha_emision') is-invalid @enderror" name="fecha_emision" id="fecha_emision" value="{{ old('fecha_emision') }}"  placeholder="Fecha Emisión">
                    @error('fecha_emision')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="fecha_caducidad">Fecha Caducidad: </label>
                    <input type="text" class="form-control @error('fecha_caducidad') is-invalid @enderror" name="fecha_caducidad" id="fecha_caducidad" value="{{ old('fecha_caducidad') }}"  placeholder="Fecha Caducidad">
                    @error('fecha_caducidad')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-12 mb-2">
                  <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input data-file-img="images" data-id="preview-images-id" type="file" class="form-control" name="imagen" id="imagen" required placeholder="Imagen" accept="image/*" onchange="imagesPreview(this)">
                  </div>
                </div>

                <div class="col-12 mb-3">
                  <div class="preview-img" data-img-preview="preview-images-id"></div>
                </div>

              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.persona-doc-identidads') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>