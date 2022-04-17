            <form id="form-edit" action="{{ route('admin.marcas.update',['id' => $marca->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $marca->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_mar">Cod Mar: </label>
                    <input type="text" class="form-control  @error('cod_mar') is-invalid @enderror" name="cod_mar" id="cod_mar" placeholder="Cod Mar" value="{{ old('cod_mar', $marca->cod_mar ?? '') }}" >
                    @error('cod_mar')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripcion" value="{{ old('descripcion', $marca->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="glosa">Glosa: </label>
                    <textarea class="form-control ckeditor  @error('glosa') is-invalid @enderror" name="glosa" id="glosa" placeholder="Glosa" cols="30" rows="6">{{ $marca->glosa }}</textarea>
                    @error('glosa')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="si" value="S"  @if($marca->publicar == "S"   ) checked="checked" @endif >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="no" value="N" @if($marca->publicar == "N"  ) checked="checked" @endif  >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 mb-2 text-center">
                  <input type="hidden" class="form-control" name="img_bd" id="img_bd" value="{{ $marca->imagen }}">
                  @if(!empty($marca->imagen))
                  <img src="{{ url($marca->imagen) }}" class="img-fluid img-view-edit mb-2">
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
                {{-- <a href="{{ route('admin.marcas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 