<div class="stats">
  <a href="{{ route('users.followings', $user->id) }}">
    <strong id="following" class="stat">
      {{$user->usersDetail->followings_count }}
    </strong>
    关注
  </a>
  <a href="{{ route('users.followers', $user->id) }}">
    <strong id="followers" class="stat">
      {{ $user->usersDetail->followers_count }}
    </strong>
    粉丝
  </a>
  <a href="{{ route('users.show', $user->id) }}">
    <strong id="statuses" class="stat">
      {{ $user->usersDetail->topics_count }}
    </strong>
   话题
  </a>
</div>
