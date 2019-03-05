@if(count($lists))
    @foreach($lists as $one)
        <div class="col-md-3 list-wrapper">
            <div class="card">
                <div class="card-body">
                    <span class="card-title" data-id="{{ $one->id }}" onclick="dashboard.editListTitle($(this))">{{ urldecode($one->title) }}</span>
                    <input type="text" value="{{ urldecode($one->title) }}" name="cardTitle" style="display: none" data-id="{{ $one->id }}"
                           onblur="dashboard.donEditList($(this))" class="form-control edit-title-card"
                            onkeypress="if(event.keyCode==13){ dashboard.editListTitle($(this)) }">
                    <span class="points" onclick="dashboard.showCardPopover($(this))">...</span>
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
                            <div class="tasking btn-light tasks draggable" data-id="{{ $t->id }}" data-name="{{ $t->name }}" data-list="{{ urldecode($one->title) }}" onclick="dashboard.openTask($(this))">
                                @php
                                    $tempEtiq = \App\Etiquettes::getEtiquettesByCarts($t->id);
                                @endphp
                                @if(!empty($tempEtiq))
                                    @foreach($tempEtiq as $q)
                                        <div class="div-list-etiq" style="background-color: {{ $q->color }}"><span class="etiqSpan">{{ $q->name }}</span> </div>
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
                <textarea class="carte-title form-control" data-list="{{ $one->id }}" style="display: none" onblur="dashboard.arbortCreateList($(this))">

                </textarea>
                <button class="btn btn-success save-list" data-list="{{ $one->id }}" data-dashboard="{{ $dashboard->id }}" style="display: none;" onclick="dashboard.saveList($(this))">Enregistrer</button>
                <button class="btn btn-primary addCard" data-card="{{ $one->id }}" onclick="dashboard.addCard($(this))">+ Ajouter une carte</button>
            </div>
        </div>
    @endforeach
    <div class="col-md-3 list-wrapper" id="listeCreator" style="display: none;">
        <div style="background-color: #dfe3e6;border-radius: .25rem;padding: 10px;">
            <form method="POST" action="{{ route('addList') }}">
                <label>Nom de la liste</label>
                <input type="hidden" name="id_dashboard" value="{{ $dashboard->id }}">
                <input type="text" value="" class="form-control edit-title-card" placeholder="Saisissez le titre de la liste" name="title" required>
                <input type="submit" class="btn btn-success" value="Ajouter une liste">
                <span style="margin-left: 15px; font-weight: 900; cursor: pointer;" onclick="dashboard.abortList()">X</span>
                @csrf
            </form>
        </div>

    </div>
@endif
<button class="btn btn-primary createListBtn" onclick="dashboard.createList($(this))" id="creatorList">Ajouter une liste</button>