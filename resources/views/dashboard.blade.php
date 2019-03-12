@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 100%;margin-top: -24px;">
        <div class="row">
            <div class="col-md-12 main-dashboard">
                <span class="dashboard-title">{{ $dashboard->name }}</span>
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
                </div>
            </div>
            <div class="main-row" id="dashboard-principal">
            @include('components.lists')
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

        @include('components.popover')
        @include('components.overlay')
        @include('components.checklist-popover')
        @include('components.etiquettes-popover')

@endsection

@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs@1.3/dist/interact.min.js"></script>
    <script src="https://unpkg.com/muuri@0.7.1/dist/muuri.min.js"></script>
    <script src="https://unpkg.com/web-animations-js@2.3.1/web-animations.min.js"></script>
    <script src="https://unpkg.com/hammerjs@2.0.8/hammer.min.js"></script>
    <script src="https://unpkg.com/muuri@0.7.1/dist/muuri.min.js"></script>
    <script src="{{ asset('js/controllers/dashboard.js') }}" ></script>
    <script src="{{ asset('js/controllers/draggable.js') }}" ></script>
    <script src="{{ asset('js/functions.js') }}" ></script>
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
        var updateList              = "{{ route('updateList') }}";
        var addCard                 = "{{ route('addCard') }}";
        var createChecklist         = "{{ route('createChecklist') }}";
        var getCartChecklistName    = "{{ route('getCartChecklistName') }}";
        var ID_USER                 = "{{ $id_user }}";
</script>
@endsection