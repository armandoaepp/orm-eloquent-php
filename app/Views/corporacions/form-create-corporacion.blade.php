            <form id="form-create" action="{{  route('admin.corporacions.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ruc">Ruc: </label>
                    <input type="text" class="form-control @error('ruc') is-invalid @enderror" name="ruc" id="ruc" value="{{ old('ruc') }}" required placeholder="Ruc">
                    @error('ruc')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="razon_social">Razon Social: </label>
                    <input type="text" class="form-control @error('razon_social') is-invalid @enderror" name="razon_social" id="razon_social" value="{{ old('razon_social') }}" required placeholder="Razon Social">
                    @error('razon_social')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="nombre_com">Nombre Com: </label>
                    <input type="text" class="form-control @error('nombre_com') is-invalid @enderror" name="nombre_com" id="nombre_com" value="{{ old('nombre_com') }}" required placeholder="Nombre Com">
                    @error('nombre_com')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ubigeo_id">Ubigeo Id: </label>
                    <select class="form-select select2-box" name="ubigeo_id" id="ubigeo_id" placeholder="Ubigeo Id">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="direccion">Direccion: </label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" id="direccion" value="{{ old('direccion') }}" required placeholder="Direccion">
                    @error('direccion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.corporacions') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>