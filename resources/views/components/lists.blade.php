@if(count($lists))
    @foreach($lists as $one)
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" data-id="{{ $one->id }}" onclick="dashboard.editListTitle($(this))">{{ urldecode($one->title) }}</h5>
                    <input type="text" value="{{ urldecode($one->title) }}" name="cardTitle" style="display: none" data-id="{{ $one->id }}" onblur="dashboard.donEditList($(this))" class="form-control edit-title-card">
                </div>
                <div>
                    @foreach($tasks as $t)
                        @if($t->id_cart == $one->id)
                            @php
                                //Need to be inside controllers->update necessary
                                $countCheck     = 0;
                                $check          = \App\Checklist::getByCarts($t->id);
                                $checkDone      = 0;
                                if($check){
                                    $countCheck     = count($check) ? count($check) : 0;
                                    foreach ($check as $c){
                                        if($c['done'] > 0){
                                            $checkDone++;
                                        }
                                    }
                                }

                                $countComment   = 0;
                                $comment        = \App\Comments::getByCart($t->id);
                                if($comment){
                                    $countComment   = count($comment) ? count($comment) : 0;
                                }
                            @endphp
                            <div class="tasking btn-light tasks" data-id="{{ $t->id }}" data-name="{{ $t->name }}" onclick="dashboard.openTask($(this))">
                                @php
                                    $tempEtiq = \App\Etiquettes::getEtiquettesByCarts($t->id);
                                @endphp
                                @if(!empty($tempEtiq))
                                    @foreach($tempEtiq as $q)
                                        <div class="div-list-etiq" style="background-color: {{ $q->color }}">{{ $q->name }}</div>
                                    @endforeach
                                    <br>
                                @endif
                                {{ $t->name }}<br>
                                <span style="@if($countCheck == 0) display: none; @endif @if($countCheck == $checkDone) background-color:#61bd4f; @endif" ><i class="fas fa-check-square"></i><span class="indice" id="doneCheck">{{ $checkDone }}</span>/<span class="indice" id="countCheck">{{ $countCheck }}</span></span>
                                <span @if($countComment == 0) style="display: none;" @endif><i class="fas fa-comment"></i><span class="indice" id="countCom">{{ $countComment }}</span></span>
                            </div>

                        @endif
                    @endforeach
                </div>
                <button class="btn btn-primary addCard" data-card="{{ $one->id }}" onclick="dashboard.addCard($(this))">+ Ajouter une carte</button>
            </div>
        </div>
    @endforeach
@endif
<button class="btn btn-primary createListBtn" data-toggle="modal" data-target="#createList">Ajouter une liste</button>