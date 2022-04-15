          <!--begin: Datatable -->
          <table id="dataTableLists" class="table table-sm table-hover table-bordered" style="width: 100%;">
            <thead>
              <tr class="bg-light text-uppercase">
                <th width="50"> Id </th> 
                <th> Cod Ec </th> 
                <th> Descripcion </th> 
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
                <td> {{ $row->cod_ec }} </td> 
                <td> {{ $row->descripcion }} </td> 
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
                      <a  class="dropdown-item btn-action" href="#" data-href="{{ route('admin.estado-civils.edit',['id' => $row->id]) }}" onclick="openModalEdit(this);event.preventDefault();" title="Editar estado_civil: {{ $title }}" type="button">
                        <i class="far fa-edit"></i> Editar
                      </a>
                      <a class="dropdown-item btn-action" href="#" data-href="{{ route('admin.estado-civils.destroy') }}" onclick="openModalDestroy(this);event.preventDefault();"  data-id="{{$row->id}}"   title="Borrar estado_civil: {{ $title }}" data-title="{{ $title }}" type="button" >
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

