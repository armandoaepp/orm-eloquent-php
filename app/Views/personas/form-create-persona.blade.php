            <form id="form-create" action="{{  route('admin.personas.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sede_id">Sede Id: </label>
                    <input type="text" class="form-control @error('sede_id') is-invalid @enderror" name="sede_id" id="sede_id" value="{{ old('sede_id') }}" required placeholder="Sede Id">
                    @error('sede_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="per_nombre">Nombre: </label>
                    <input type="text" class="form-control @error('per_nombre') is-invalid @enderror" name="per_nombre" id="per_nombre" value="{{ old('per_nombre') }}" required placeholder="Nombre">
                    @error('per_nombre')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="per_apellidos">Apellidos: </label>
                    <input type="text" class="form-control @error('per_apellidos') is-invalid @enderror" name="per_apellidos" id="per_apellidos" value="{{ old('per_apellidos') }}" required placeholder="Apellidos">
                    @error('per_apellidos')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="fecha_nac">Fecha Nac: </label>
                    <input type="text" class="form-control @error('fecha_nac') is-invalid @enderror" name="fecha_nac" id="fecha_nac" value="{{ old('fecha_nac') }}"  placeholder="Fecha Nac">
                    @error('fecha_nac')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="per_tipo">Tipo: </label>
                    <input type="text" class="form-control @error('per_tipo') is-invalid @enderror" name="per_tipo" id="per_tipo" value="{{ old('per_tipo') }}" required placeholder="Tipo">
                    @error('per_tipo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.personas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>