<div class="favorite-list-item">
    <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m"
         @php
            $url_image = Chatify::getUserWithAvatar($user)->avatar;
            $url_image = str_replace('http://localhost/', config('app.url_image'), $url_image);
         @endphp
        style="background-image: url('{{ $url_image }}');">
    </div>
    {{--         url('https://localhost/ecommerce/public/storage/users-avatar/default-avatar.png')--}}

    <p>{{ strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name }}</p>
</div>
