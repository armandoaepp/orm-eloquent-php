            <form id="form-edit" action="{{ route('admin.sub-categorias.update',['id' => $sub_categoria->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $sub_categoria->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="categoria_id">Categoria Id: </label>
                    <select class="form-select select2-box" name="categoria_id" id="categoria_id" placeholder="Categoria Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="cod_subcat">Cod Subcat: </label>
                    <input type="text" class="form-control  @error('cod_subcat') is-invalid @enderror" name="cod_subcat" id="cod_subcat" placeholder="Cod Subcat" value="{{ old('cod_subcat', $sub_categoria->cod_subcat ?? '') }}" >
                    @error('cod_subcat')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripcion" value="{{ old('descripcion', $sub_categoria->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="glosa">Glosa: </label>
                    <textarea class="form-control ckeditor  @error('glosa') is-invalid @enderror" name="glosa" id="glosa" placeholder="Glosa" cols="30" rows="6">{{ $sub_categoria->glosa }}</textarea>
                    @error('glosa')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="email" class="d-block">Publicar </label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="si" value="S"  @if($sub_categoria->publicar == "S"   ) checked="checked" @endif >
                      <label class="form-check-label" for="si">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="publicar" id="no" value="N" @if($sub_categoria->publicar == "N"  ) checked="checked" @endif  >
                      <label class="form-check-label" for="no">NO</label>
                    </div>
                  </div>
                </div>

                <div class="col-md-12 mb-2 text-center">
                  <input type="hidden" class="form-control" name="img_bd" id="img_bd" value="{{ $sub_categoria->imagen }}">
                  @if(!empty($sub_categoria->imagen))
                  <img src="{{ url($sub_categoria->imagen) }}" class="img-fluid img-view-edit mb-2">
                  <hr>
                  @endif
                </div>
                <div class="col-12 mb-2">
                  <div class="form-group">
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="imagen">Nueva Imagen</label>
                      </div>
                      <input data-file-img="images" data-id="preview-images-id" type="file" class="form-control" name="imagen" id="imagen" placeholder="Imagen" accept="image/*">
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-2">
                  <div class="preview-img" data-img-preview="preview-images-id"></div>
                </div>

              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.sub-categorias') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 