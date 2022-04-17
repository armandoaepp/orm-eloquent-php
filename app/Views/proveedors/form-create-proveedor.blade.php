            <form id="form-create" action="{{  route('admin.proveedors.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="razon_social">Razón Social: </label>
                    <input type="text" class="form-control @error('razon_social') is-invalid @enderror" name="razon_social" id="razon_social" value="{{ old('razon_social') }}" required placeholder="Razón Social">
                    @error('razon_social')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="nombre_comercial">Nombre Comercial: </label>
                    <input type="text" class="form-control @error('nombre_comercial') is-invalid @enderror" name="nombre_comercial" id="nombre_comercial" value="{{ old('nombre_comercial') }}" required placeholder="Nombre Comercial">
                    @error('nombre_comercial')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="condicion_su">Condición: </label>
                    <input type="text" class="form-control @error('condicion_su') is-invalid @enderror" name="condicion_su" id="condicion_su" value="{{ old('condicion_su') }}" required placeholder="Condición">
                    @error('condicion_su')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="estado_su">Estado: </label>
                    <input type="text" class="form-control @error('estado_su') is-invalid @enderror" name="estado_su" id="estado_su" value="{{ old('estado_su') }}" required placeholder="Estado">
                    @error('estado_su')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="domicilio_fiscal">Domicilio Fiscal: </label>
                    <input type="text" class="form-control @error('domicilio_fiscal') is-invalid @enderror" name="domicilio_fiscal" id="domicilio_fiscal" value="{{ old('domicilio_fiscal') }}" required placeholder="Domicilio Fiscal">
                    @error('domicilio_fiscal')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ubigeo_su">Ubigeo: </label>
                    <input type="text" class="form-control @error('ubigeo_su') is-invalid @enderror" name="ubigeo_su" id="ubigeo_su" value="{{ old('ubigeo_su') }}"  placeholder="Ubigeo">
                    @error('ubigeo_su')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="glosa">Observación: </label>
                    <textarea class="form-control ckeditor @error('glosa') is-invalid @enderror" name="glosa" id="glosa" placeholder="Observación" cols="30" rows="4">{{ old('glosa') }}</textarea>
                    @error('glosa')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.proveedors') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>