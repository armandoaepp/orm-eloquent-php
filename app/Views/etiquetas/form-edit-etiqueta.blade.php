            <form id="form-edit" action="{{ route('admin.etiquetas.update',['id' => $etiqueta->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $etiqueta->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="desc_eti">Descripción: </label>
                    <input type="text" class="form-control  @error('desc_eti') is-invalid @enderror" name="desc_eti" id="desc_eti" placeholder="Descripción" value="{{ old('desc_eti', $etiqueta->desc_eti ?? '') }}" >
                    @error('desc_eti')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.etiquetas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 