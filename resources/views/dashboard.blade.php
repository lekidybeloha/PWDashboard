@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 main-dashboard">
                <h2>{{ $dashboard->name }}</h2>
                <div class="dashboard-header">
                    <a href="#" class="dashboard-param" id="updateFavorite" onclick="dashboard.updateFavoris()">
                        @if($dashboard->favoris == 0)
                            <i class="far fa-star" id="iconFavorites" data-id="{{ $dashboard->id }}" data-fav="1"></i>
                        @else
                            <i class="fas fa-star" id="iconFavorites" data-id="{{ $dashboard->id }}" data-fav="0"></i>
                        @endif
                    </a> | <a href="#" class="dashboard-param">@if($dashboard->privacy == 0) Public @else Personnel @endif </a>
                    |
                    <div class="rounded-circle coop">{{ $username[0] }}</div>
                    @if(!empty($coop))
                        @foreach($coop as $one)
                            <div class="rounded-circle coop">{{ $one->name[0] }}</div>
                        @endforeach
                    @endif
                    <div class="rounded-circle coop" onclick="dashboard.addCoop()"><i class="fas fa-user-plus"></i></div>
                    |<a href="#" class="dashboard-param">Afficher le menu</a>
                </div>
            </div>
            <div class="main-row" id="dashboard-principal">
            @include('components.lists')
            </div>

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
                                <button class="btn btn-success" id="saveDesc" onclick="dashboard.saveDescription()">Enregistrer</button>

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
                                    <button class="btn btn-success" id="saveChecklist" onclick="dashboard.saveChecklist()">Enregistrer</button>
                                    <button class="btn btn-danger" id="cancelChecklist">Annuler</button>
                                </div>
                                <br>
                                <label class="title">Commentaires</label>
                                <div id="listComments">
                                </div>
                                <label >Ajouter un commentaire</label>
                                <div id="addComments">
                                    <textarea id="comment" class="form-control"></textarea>
                                    <button class="btn btn-success" id="saveComment" onclick="dashboard.saveComment()">Enregistrer</button>
                                </div>
                            </div>
                            <div style="width: 20%; text-align: center">
                                <label>AJOUTER A LA CARTE</label>
                                <button type="button" class="btn btn-secondary" id="etiqButton">Etiquettes</button>
                                <div id="etiqList">
                                    @include('components.etiquettes')
                                </div>
                                <a href="#" id="etiqForm">Créer une étiquette</a>
                                <div id="etiqCreate" style="display: none;">
                                    <input type="text" id="etiqName" class="form-control" placeholder="nom de l'etiquette">
                                    <label>Couleur</label>
                                    <input type="color" id="etiqColor" class="form-control" placeholder="code couleur">
                                    <input type="hidden" id="id_dash" class="form-control" placeholder="code couleur" value="{{ $dashboard->id }}">
                                    <button type="button" class="btn btn-success" id="createEtiquette" onclick="dashboard.createEtiquette()">Valider</button>
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

            <!--MODAL SECTION : CREATE INVITATION-->
            <div id="addCoop" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Envoyer une invitation</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="" id="formInvite">
                                <label>Adresse email</label>
                                <input type="email" name="email" class="form-control" id="emailInvite" required>
                                <label>Message</label>
                                <input type="text" name="text" class="form-control" id="textInvite" value="Je travaille sur ce projet dans PWDashboard et je voulais le partager avec vous.">
                                <input type="hidden" name="id_dashboard" id="dashboardInvite" value="{{ $dashboard->id }}">
                                <input type="submit" class="btn btn-primary form-control"  value="Envoyer une invitation" id="sendInviteBtn">
                                @csrf
                            </form>
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
    <script src="{{ asset('js/dashboard.js') }}" ></script>
    <script>
        var ID_DASHBOARD            = "{{ $dashboard->id }}";
        var cartDetails             = "{{ route('cartDetails') }}";
        var saveCartDetails         = "{{ route('saveCartDetails') }}";
        var saveCartChecklist       = "{{ route('saveCartChecklist') }}";
        var getCartChecklist        = "{{ route('getCartChecklist') }}";
        var updateChecklist         = "{{ route('updateChecklist') }}";
        var getComments             = "{{ route('getComments') }}";
        var saveComments            = "{{ route('saveComments') }}";
        var updateFavorites         = "{{ route('updateDashboardFavorite') }}";
        var addEtiquettes           = "{{ route('addEtiquette') }}";
        var insertOrDeleteEtiquette = "{{ route('insertOrDeleteEtiquette') }}";
        var updateMainDashboard     = "{{ route('updateMainDashboard', ['id' => $dashboard->id]) }}";
        var checkEtiquettes         = "{{ route('checkEtiquette') }}";
        var updateEtiquetteList     = "{{ route('updateEtiquetteList', ['id' => $dashboard->id]) }}";
        var sendingInvitation       = "{{ route('sendInvitation') }}";
    </script>
@endsection