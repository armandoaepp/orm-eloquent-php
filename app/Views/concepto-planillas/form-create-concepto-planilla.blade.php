            <form id="form-create" action="{{  route('admin.concepto-planillas.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="empleado_id">Empleado Id: </label>
                    <input type="text" class="form-control @error('empleado_id') is-invalid @enderror" name="empleado_id" id="empleado_id" value="{{ old('empleado_id') }}" required placeholder="Empleado Id">
                    @error('empleado_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="periodo_id">Periodo Id: </label>
                    <input type="text" class="form-control @error('periodo_id') is-invalid @enderror" name="periodo_id" id="periodo_id" value="{{ old('periodo_id') }}"  placeholder="Periodo Id">
                    @error('periodo_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="tipo_concepto_id">Tipo Concepto Id: </label>
                    <input type="text" class="form-control @error('tipo_concepto_id') is-invalid @enderror" name="tipo_concepto_id" id="tipo_concepto_id" value="{{ old('tipo_concepto_id') }}"  placeholder="Tipo Concepto Id">
                    @error('tipo_concepto_id')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="fecha">Fecha: </label>
                    <input type="text" class="form-control @error('fecha') is-invalid @enderror" name="fecha" id="fecha" value="{{ old('fecha') }}" required placeholder="Fecha">
                    @error('fecha')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="monto">Monto: </label>
                    <input type="text" class="form-control @error('monto') is-invalid @enderror" name="monto" id="monto" value="{{ old('monto') }}" required placeholder="Monto">
                    @error('monto')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripcion: </label>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" required placeholder="Descripcion">
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="estado_pagado">Estado Pagado: </label>
                    <input type="text" class="form-control @error('estado_pagado') is-invalid @enderror" name="estado_pagado" id="estado_pagado" value="{{ old('estado_pagado') }}" required placeholder="Estado Pagado">
                    @error('estado_pagado')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_reg">User Id Reg: </label>
                    <input type="text" class="form-control @error('user_id_reg') is-invalid @enderror" name="user_id_reg" id="user_id_reg" value="{{ old('user_id_reg') }}" required placeholder="User Id Reg">
                    @error('user_id_reg')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="user_id_upd">User Id Upd: </label>
                    <input type="text" class="form-control @error('user_id_upd') is-invalid @enderror" name="user_id_upd" id="user_id_upd" value="{{ old('user_id_upd') }}" required placeholder="User Id Upd">
                    @error('user_id_upd')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.concepto-planillas') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>