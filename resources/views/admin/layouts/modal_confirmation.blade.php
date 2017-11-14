<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="user_delete_confirm_title">@if($type === 'delete') Deaktiviraj korisnika @elseif($type === 'restore') Aktiviraj korisnika @endif</h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
        @if($type === 'delete') <div>Jeste li sigurni da želite deaktivirati korisnika - {{$user->name}} {{$user->surname}} s ID-om {{$user->id}}?</div>
        @elseif($type === 'restore') <div>Jeste li sigurni da želite aktivirati korisnika - {{$user->name}} {{$user->surname}} s ID-om {{$user->id}}?</div> @endif
    @endif
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Poništi</button>
  @if(!$error)
    <a href="{{ $confirm_route }}" type="button" class="btn btn-danger">Potvrdi</a>
  @endif
</div>
