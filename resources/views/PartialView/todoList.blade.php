 <div class="col-md-6 grid-margin grid-margin-md-0 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Todo list</h4>
                  <div class="add-items d-flex">
                    <input type="text" class="form-control todo-list-input"  placeholder="What do you need to do today?">
                    <button class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                  </div>
                  <div class="list-wrapper">
                    <ul class="d-flex flex-column-reverse todo-list">
                      <li class="completed">
                      </li>
                      @if(count($toDoList) > 0)
                      @foreach($toDoList as $listTodo)
                      <li>
                        <span  class="remove-parent{{$listTodo->id}}">
                          <div class="form-check" style="width: 450px; word-break: break-all;">
                            <label class="form-check-label">
                              @if($listTodo->flag == 1)
                              <input class="checkbox turnOnOff" id="{{$listTodo->id}}" type="checkbox" checked>
                              @else
                              <input class="checkbox turnOnOff" id="{{$listTodo->id}}" type="checkbox">
                              @endif
                              <b> {{ substr($listTodo->caption,0, 450) }}  </b>
                              <i class='input-helper checkFlag' id="{{$listTodo->id}}"></i>
                            </label>
                            <div align="right">
                              <small><i class="text-success text-right"> {{ $listTodo->posted }} &nbsp;</i></small>
                            </div>
                          </div>
                        </span>
                        <i class="remove icon-close" id="{{$listTodo->id}}"></i>&nbsp;&nbsp;
                        <!--view Model starts-->
                          <div class="text-center">
                            <span type="button" data-toggle="modal" data-target="#view{{$listTodo->id}}"><i class="view icon-eye"></i></span>
                          </div>
                          <div class="modal fade" id="view{{$listTodo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel-2">Todo List Details</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  {{($listTodo->caption)}}
                                  <br />
                                  Added On: <span class="text-success"> {{ $listTodo->posted }}  </span>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <!--Model ends-->
                      </li>
                      @endforeach
                       <br/>
                      <div align="right">
                          Showing {{($toDoList->currentpage()-1)*$toDoList->perpage()+1}}
                          to {{$toDoList->currentpage()*$toDoList->perpage()}}
                          of  {{$toDoList->total()}} entries
                      </div>
                      <div class="hidden-print">{{ $toDoList->links() }}</div>   
                      @else
                        <div class="text-muted text-warning"><b><big>No Todo List Found yet !</big></b></div>
                      @endif
                    </ul>
                  </div>
                </div>
              </div>
            </div>