{{-- Circular profile picture. Pass $user and $size (pixels). Shows the first letter if there is no picture. --}}
@if ($user->profilePhotoUrl())
    <img src="{{ $user->profilePhotoUrl() }}" alt="Profile picture of {{ $user->name }}"
         class="avatar" style="width: {{ $size }}px; height: {{ $size }}px;">
@else
    <span class="avatar avatar-initial" aria-hidden="true"
          style="width: {{ $size }}px; height: {{ $size }}px; font-size: {{ $size / 2.5 }}px;">{{ mb_substr($user->name, 0, 1) }}</span>
@endif
