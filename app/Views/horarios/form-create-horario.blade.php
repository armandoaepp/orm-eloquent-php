            <form id="form-create" action="{{  route('admin.horarios.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" class="form-control" name="id" id="id" value="">
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
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" required placeholder="Descripción">
                    @error('descripcion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ingreso">Ingreso: </label>
                    <input type="time" class="form-control @error('ingreso') is-invalid @enderror" name="ingreso" id="ingreso" value="{{ old('ingreso') }}" required placeholder="Ingreso">
                    @error('ingreso')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="salida">Salida: </label>
                    <input type="time" class="form-control @error('salida') is-invalid @enderror" name="salida" id="salida" value="{{ old('salida') }}" required placeholder="Salida">
                    @error('salida')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ingreso2">Ingreso 2: </label>
                    <input type="time" class="form-control @error('ingreso2') is-invalid @enderror" name="ingreso2" id="ingreso2" value="{{ old('ingreso2') }}"  placeholder="Ingreso 2">
                    @error('ingreso2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="salida2">Salida 2: </label>
                    <input type="time" class="form-control @error('salida2') is-invalid @enderror" name="salida2" id="salida2" value="{{ old('salida2') }}"  placeholder="Salida 2">
                    @error('salida2')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ingreso3">Ingreso 3: </label>
                    <input type="time" class="form-control @error('ingreso3') is-invalid @enderror" name="ingreso3" id="ingreso3" value="{{ old('ingreso3') }}"  placeholder="Ingreso 3">
                    @error('ingreso3')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="salida3">Salida 3: </label>
                    <input type="time" class="form-control @error('salida3') is-invalid @enderror" name="salida3" id="salida3" value="{{ old('salida3') }}"  placeholder="Salida 3">
                    @error('salida3')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="duracion">Duración: </label>
                    <input type="number" class="form-control @error('duracion') is-invalid @enderror" name="duracion" id="duracion" value="{{ old('duracion') }}" required placeholder="Duración">
                    @error('duracion')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_continuo">Horario Continuo: </label>
                    <input type="checkbox" class="form-control @error('is_continuo') is-invalid @enderror" name="is_continuo" id="is_continuo" value="{{ old('is_continuo') }}"  placeholder="Horario Continuo">
                    @error('is_continuo')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="dia_siguiente">Día Siguiente: </label>
                    <input type="checkbox" class="form-control @error('dia_siguiente') is-invalid @enderror" name="dia_siguiente" id="dia_siguiente" value="{{ old('dia_siguiente') }}"  placeholder="Día Siguiente">
                    @error('dia_siguiente')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ing_tol_antes">Tolerancia de Ingreso Antes: </label>
                    <input type="number" class="form-control @error('ing_tol_antes') is-invalid @enderror" name="ing_tol_antes" id="ing_tol_antes" value="{{ old('ing_tol_antes') }}"  placeholder="Tolerancia de Ingreso Antes">
                    @error('ing_tol_antes')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="ing_tol_despues">Tolerancia de Ingreso Después: </label>
                    <input type="number" class="form-control @error('ing_tol_despues') is-invalid @enderror" name="ing_tol_despues" id="ing_tol_despues" value="{{ old('ing_tol_despues') }}"  placeholder="Tolerancia de Ingreso Después">
                    @error('ing_tol_despues')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sal_tol_antes">Tolerancia de Salida Antes: </label>
                    <input type="number" class="form-control @error('sal_tol_antes') is-invalid @enderror" name="sal_tol_antes" id="sal_tol_antes" value="{{ old('sal_tol_antes') }}"  placeholder="Tolerancia de Salida Antes">
                    @error('sal_tol_antes')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="sal_tol_despues">Tolerancia de Salida Despues: </label>
                    <input type="number" class="form-control @error('sal_tol_despues') is-invalid @enderror" name="sal_tol_despues" id="sal_tol_despues" value="{{ old('sal_tol_despues') }}"  placeholder="Tolerancia de Salida Despues">
                    @error('sal_tol_despues')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12 mb-2">
                  <div class="form-group">
                    <label for="is_tol_ajustar">Ajustar Tolerancia a Horario: </label>
                    <input type="checkbox" class="form-control @error('is_tol_ajustar') is-invalid @enderror" name="is_tol_ajustar" id="is_tol_ajustar" value="{{ old('is_tol_ajustar') }}"  placeholder="Ajustar Tolerancia a Horario">
                    @error('is_tol_ajustar')
                    <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                  </div>
                </div>

                <ul class="nav nav-tabs">
                  <li class="active"><a data-bs-toggle="tab" href="#home">Home</a></li>
                  <li><a data-bs-toggle="tab" href="#menu1">Menu 1</a></li>
                  <li><a data-bs-toggle="tab" href="#menu2">Menu 2</a></li>
                </ul>

                <div class="tab-content">
                  <div id="home" class="tab-pane fade in active">
                    <h3>HOME</h3>
                    <p>Some content.</p>
                  </div>
                  <div id="menu1" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                  </div>
                  <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Some content in menu 2.</p>
                  </div>
                </div>


              </div>

              <div class="w-100 text-center">
                {{--  <a href="{{ route('admin.horarios') }}" class="btn btn-outline-danger"> <i class="fas fa-ban"></i> Cancelar</a> --}}
                <button type="button" class="btn btn-outline-danger text-uppercase" data-bs-dismiss="modal"> <i class="fas fa-ban"></i> Cerrar </button>
                <button type="submit" class="btn btn-outline-primary"> <i class="fas fa-save"></i> Guardar</button>
              </div>

            </form>