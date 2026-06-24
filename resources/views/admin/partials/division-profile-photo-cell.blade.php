@if($item->profile_photo)
  <img src="{{ $item->profile_photo }}" alt="Foto Profil" style="width:80px;height:80px;object-fit:cover;border-radius:50%;">
@else
  <span class="text-muted">Tidak ada foto profil</span>
@endif
