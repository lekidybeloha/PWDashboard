@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>{{ $dashboard->name }}</h1>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createList">Créer une liste</button>
            </div>

            @if(count($lists))
                @foreach($lists as $one)
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $one->title }}</h5>

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
                                        <div class="tasking">
                                            <button type="button" class="btn btn-light form-control tasks" data-id="{{ $t->id }}" data-name="{{ $t->name }}">
                                                {{ $t->name }}<br>
                                                <i class="fas fa-check-square"></i><span class="indice" id="doneCheck">{{ $checkDone }}</span>/<span class="indice" id="countCheck">{{ $countCheck }}</span>
                                                <i class="fas fa-comment"></i><span class="indice" id="countCom">{{ $countComment }}</span>
                                            </button>
                                        </div>

                                    @endif
                                @endforeach
                            </div>
                            <button class="btn btn-primary addCard" data-card="{{ $one->id }}">+ Ajouter une carte</button>
                        </div>
                    </div>
                @endforeach
            @endif

            <!--MODAL SECTION : CREATE LIST-->
            <div id="createList" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Créer une liste</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('addList') }}">
                                <label>Nom de la liste</label>
                                <input type="text" name="title" class="form-control" required>
                                <input type="hidden" name="id_dashboard" value="{{ $dashboard->id }}">
                                <input type="submit" class="btn btn-primary form-control create-tab" value="Créer la liste">
                                @csrf
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>

                </div>
            </div>

            <!--MODAL SECTION : CREATE CARD-->
            <div id="createCard" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Créer un carte</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('addCard') }}">
                                <label>Nom de la carte</label>
                                <input type="text" name="name" class="form-control" required>
                                <input type="hidden" value="" id="id_card" name="id_card">
                                <input type="hidden" name="id_dashboard" value="{{ $dashboard->id }}">
                                <input type="submit" class="btn btn-primary form-control create-tab" value="Créer la carte">
                                @csrf
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>

                </div>
            </div>

            <!--MODAL SECTION : CARD DETAILS-->
            <div id="cartDetails" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="task-title"></h4>
                        </div>
                        <div class="modal-body" style="display: inline-flex;">
                            <div style="width: 80%">
                                <label>Description</label>
                                <textarea id="descCart" class="form-control">Ajouter une description ici</textarea>
                                <input type="hidden" value="" id="id_task">
                                <button class="btn btn-success" id="saveDesc">Enregistrer</button>

                                <label class="title">Checklist</label>
                                <div class="progress">
                                    <div class="progress-bar" id="checkProgress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div id="listChecklist">
                                </div>

                                <button class="btn btn-info" id="addChecklist">Ajout checklist</button>
                                <div id="checklistForm" style="display: none;">
                                    <input type="text" value="" id="checklistText" name="name" class="form-control">
                                    <input type="hidden" value="{{ $id_user }}" name="id_user" id="id_user">
                                    <button class="btn btn-success" id="saveChecklist">Enregistrer</button>
                                    <button class="btn btn-danger" id="cancelChecklist">Annuler</button>
                                </div>
                                <br>
                                <label class="title">Commentaires</label>
                                <div id="listComments">
                                </div>
                                <label >Ajouter un commentaire</label>
                                <div id="addComments">
                                    <textarea id="comment" class="form-control"></textarea>
                                    <button class="btn btn-success" id="saveComment">Enregistrer</button>
                                </div>
                            </div>
                            <div style="width: 20%; text-align: center">
                                <label>AJOUTER A LA CARTE</label>
                                <button type="button" class="btn btn-secondary" id="etiqButton">Etiquettes</button>
                                <div id="etiqList">

                                </div>
                                <a href="#" id="etiqForm">Créer une étiquette</a>
                                <div id="etiqCreate" style="display: none;">
                                    <input type="text" id="etiqName" class="form-control" placeholder="nom de l'etiquette">
                                    <input type="text" id="etiqColor" class="form-control" placeholder="code couleur">
                                    <button type="button" class="btn btn-success" id="createEtiquette">Valider</button>
                                    <button type="button" class="btn btn-danger" id="annulateEtiquette">Annuler</button>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>

                </div>
            </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="{{ asset('public/js/dashboard.js') }}" ></script>
    <script>

        var cartDetails         = "{{ route('cartDetails') }}";
        var saveCartDetails     = "{{ route('saveCartDetails') }}";
        var saveCartChecklist   = "{{ route('saveCartChecklist') }}";
        var getCartChecklist    = "{{ route('getCartChecklist') }}";
        var updateChecklist     = "{{ route('updateChecklist') }}";
        var getComments         = "{{ route('getComments') }}";
        var saveComments        = "{{ route('saveComments') }}";

        $('.tasking').draggable({helper: "clone",
            cursor: "move",
            revert: true});
        //$('.tasks').droppable();
    </script>
@endsection