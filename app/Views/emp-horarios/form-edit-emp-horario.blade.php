            <form id="form-edit" action="{{ route('admin.emp-horarios.update',['id' => $emp_horario->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf @method("put")
              <input type="hidden" class="form-control" name="id" id="id" value="{{ $emp_horario->id }}">
              <div class="row">
                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="area_id">Area: </label>
                    <select class="form-select select2-box" name="area_id" id="area_id" placeholder="Area">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="tipo_jordana_id">Tipo Jornada: </label>
                    <select class="form-select select2-box" name="tipo_jordana_id" id="tipo_jordana_id" placeholder="Tipo Jornada">
                      <option value="" selected disabled hidden>Seleccionar </option> 
                      <option value="text">text</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="descripcion">Descripción: </label>
                    <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" placeholder="Descripción" value="{{ old('descripcion', $emp_horario->descripcion ?? '') }}" >
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ingreso">Ingreso: </label>
                    <input type="time" class="form-control  @error('ingreso') is-invalid @enderror" name="ingreso" id="ingreso" placeholder="Ingreso" value="{{ old('ingreso', $emp_horario->ingreso ?? '') }}" >
                    @error('ingreso')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="salida">Salida: </label>
                    <input type="time" class="form-control  @error('salida') is-invalid @enderror" name="salida" id="salida" placeholder="Salida" value="{{ old('salida', $emp_horario->salida ?? '') }}" >
                    @error('salida')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ingreso2">Ingreso 2: </label>
                    <input type="time" class="form-control  @error('ingreso2') is-invalid @enderror" name="ingreso2" id="ingreso2" placeholder="Ingreso 2" value="{{ old('ingreso2', $emp_horario->ingreso2 ?? '') }}" >
                    @error('ingreso2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="salida2">Salida 2: </label>
                    <input type="time" class="form-control  @error('salida2') is-invalid @enderror" name="salida2" id="salida2" placeholder="Salida 2" value="{{ old('salida2', $emp_horario->salida2 ?? '') }}" >
                    @error('salida2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ingreso3">Ingreso 3: </label>
                    <input type="time" class="form-control  @error('ingreso3') is-invalid @enderror" name="ingreso3" id="ingreso3" placeholder="Ingreso 3" value="{{ old('ingreso3', $emp_horario->ingreso3 ?? '') }}" >
                    @error('ingreso3')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="salida3">Salida 3: </label>
                    <input type="time" class="form-control  @error('salida3') is-invalid @enderror" name="salida3" id="salida3" placeholder="Salida 3" value="{{ old('salida3', $emp_horario->salida3 ?? '') }}" >
                    @error('salida3')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="duracion">Duración: </label>
                    <input type="number" class="form-control  @error('duracion') is-invalid @enderror" name="duracion" id="duracion" placeholder="Duración" value="{{ old('duracion', $emp_horario->duracion ?? '') }}" >
                    @error('duracion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_continuo">Horario Continuo: </label>
                    <input type="checkbox" class="form-control  @error('is_continuo') is-invalid @enderror" name="is_continuo" id="is_continuo" placeholder="Horario Continuo" value="{{ old('is_continuo', $emp_horario->is_continuo ?? '') }}" >
                    @error('is_continuo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="dia_siguiente">Día Siguiente: </label>
                    <input type="checkbox" class="form-control  @error('dia_siguiente') is-invalid @enderror" name="dia_siguiente" id="dia_siguiente" placeholder="Día Siguiente" value="{{ old('dia_siguiente', $emp_horario->dia_siguiente ?? '') }}" >
                    @error('dia_siguiente')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ing_tol_antes">Tolerancia de Ingreso Antes: </label>
                    <input type="number" class="form-control  @error('ing_tol_antes') is-invalid @enderror" name="ing_tol_antes" id="ing_tol_antes" placeholder="Tolerancia de Ingreso Antes" value="{{ old('ing_tol_antes', $emp_horario->ing_tol_antes ?? '') }}" >
                    @error('ing_tol_antes')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ing_tol_despues">Tolerancia de Ingreso Después: </label>
                    <input type="number" class="form-control  @error('ing_tol_despues') is-invalid @enderror" name="ing_tol_despues" id="ing_tol_despues" placeholder="Tolerancia de Ingreso Después" value="{{ old('ing_tol_despues', $emp_horario->ing_tol_despues ?? '') }}" >
                    @error('ing_tol_despues')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sal_tol_antes">Tolerancia de Salida Antes: </label>
                    <input type="number" class="form-control  @error('sal_tol_antes') is-invalid @enderror" name="sal_tol_antes" id="sal_tol_antes" placeholder="Tolerancia de Salida Antes" value="{{ old('sal_tol_antes', $emp_horario->sal_tol_antes ?? '') }}" >
                    @error('sal_tol_antes')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sal_tol_despues">Tolerancia de Salida Despues: </label>
                    <input type="number" class="form-control  @error('sal_tol_despues') is-invalid @enderror" name="sal_tol_despues" id="sal_tol_despues" placeholder="Tolerancia de Salida Despues" value="{{ old('sal_tol_despues', $emp_horario->sal_tol_despues ?? '') }}" >
                    @error('sal_tol_despues')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_tol_ajustar">Ajustar Tolerancia a Horario: </label>
                    <input type="checkbox" class="form-control  @error('is_tol_ajustar') is-invalid @enderror" name="is_tol_ajustar" id="is_tol_ajustar" placeholder="Ajustar Tolerancia a Horario" value="{{ old('is_tol_ajustar', $emp_horario->is_tol_ajustar ?? '') }}" >
                    @error('is_tol_ajustar')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{-- <a href="{{ route('admin.emp-horarios') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form> 