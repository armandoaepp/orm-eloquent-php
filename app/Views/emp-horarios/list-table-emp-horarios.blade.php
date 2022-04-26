          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered" style="width: 100%;">
            <thead>
              <tr class="bg-light text-uppercase">
                <th width="50"> Id </th> 
                <th> Area </th> 
                <th> Tipo Jornada </th> 
                <th> Descripción </th> 
                <th> Ingreso </th> 
                <th> Salida </th> 
                <th> Ingreso 2 </th> 
                <th> Salida 2 </th> 
                <th> Ingreso 3 </th> 
                <th> Salida 3 </th> 
                <th> Duración </th> 
                <th> Horario Continuo </th> 
                <th> Día Siguiente </th> 
                <th> Tolerancia de Ingreso Antes </th> 
                <th> Tolerancia de Ingreso Después </th> 
                <th> Tolerancia de Salida Antes </th> 
                <th> Tolerancia de Salida Despues </th> 
                <th> Ajustar Tolerancia a Horario </th> 
                <th width="50" title="Estado">Est.</th>
                <th width="50"> Acciones </th>
              </tr>
            </thead>
            <tbody>

            @foreach ($data as $row)

            @php
              $title = $row->descripcion;
            @endphp

              <tr @if ($row->estado== 0) class="row-disabled" @endif>
                <td> {{ str_pad($row->id, 3, "0", STR_PAD_LEFT) }} </td> 
                <td> {{ $row->area_id }} </td> 
                <td> {{ $row->tipo_jordana_id }} </td> 
                <td> {{ $row->descripcion }} </td> 
                <td> {{ $row->ingreso }} </td> 
                <td> {{ $row->salida }} </td> 
                <td> {{ $row->ingreso2 }} </td> 
                <td> {{ $row->salida2 }} </td> 
                <td> {{ $row->ingreso3 }} </td> 
                <td> {{ $row->salida3 }} </td> 
                <td> {{ $row->duracion }} </td> 
                <td> {{ $row->is_continuo }} </td> 
                <td> {{ $row->dia_siguiente }} </td> 
                <td> {{ $row->ing_tol_antes }} </td> 
                <td> {{ $row->ing_tol_despues }} </td> 
                <td> {{ $row->sal_tol_antes }} </td> 
                <td> {{ $row->sal_tol_despues }} </td> 
                <td> {{ $row->is_tol_ajustar }} </td> 
                <td class="text-center">
                  <div class="form-check form-switch d-inline-block">
                    <input type="checkbox" onchange="desactivar(this);" class="switch-delete form-check-input" value="{{ $row->id }}" data-estado="{{ $row->estado }}" id="delete-{{ $loop->index }}" @if ($row->estado == 1) checked @endif role="switch">
                  </div>
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm lh-1 dropdown-toggle btn-action" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                      </svg>
                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                        <path d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z" />
                      </svg>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a  class="dropdown-item btn-action" href="#" data-href="{{ route('admin.emp-horarios.edit',['id' => $row->id]) }}" onclick="openModalEdit(this);event.preventDefault();" title="Editar emp_horario: {{ $title }}" type="button">
                        <i class="far fa-edit"></i> Editar
                      </a>
                      <a class="dropdown-item btn-action" href="#" data-href="{{ route('admin.emp-horarios.destroy') }}" onclick="openModalDestroy(this);event.preventDefault();"  data-id="{{$row->id}}"   title="Borrar emp_horario: {{ $title }}" data-title="{{ $title }}" type="button" >
                        <i class="far fa-trash-alt"></i> Borrar Registro
                      </a>
                    </div>
                  </div>
                </td>

              </tr>
            @endforeach
            </tbody>
          </table>
          <!--end: Datatable -->

