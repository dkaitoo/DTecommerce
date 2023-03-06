{{-- -------------------- Saved Messages -------------------- --}}
{{--@if($get == 'saved')--}}
{{--    <table class="messenger-list-item m-li-divider" data-contact="{{ Auth::user()->id }}">--}}
{{--        <tr data-action="0">--}}
{{--            --}}{{-- Avatar side --}}
{{--            <td>--}}
{{--            <div class="avatar av-m" style="background-color: #d9efff; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">--}}
{{--                <span class="far fa-bookmark" style="font-size: 22px; color: #68a5ff;"></span>--}}
{{--            </div>--}}
{{--            </td>--}}
{{--            --}}{{-- center side --}}
{{--            <td>--}}
{{--                <p data-id="{{ Auth::user()->id }}" data-type="user">Lưu trữ tin nhắn<span>Bạn</span></p>--}}
{{--                <span>Lưu tin nhắn bí mật</span>--}}
{{--            </td>--}}
{{--        </tr>--}}
{{--    </table>--}}
{{--@endif--}}

{{-- -------------------- All users/group list -------------------- --}}
@if($get == 'users')
<table class="messenger-list-item" data-contact="{{ $user->id }}">
    <tr data-action="0">
        {{-- Avatar side khi có tin nhắn --}}
        <td style="position: relative">
            @if($user->active_status)
                <span class="activeStatus"></span>
            @endif
        <div class="avatar av-m"
         @php
             $url_image = $user->avatar;
             $url_image = str_replace('http://localhost/', config('app.url_image'), $url_image);
         @endphp
        style="background-image: url('{{ $url_image }}');">
        </div>
        </td>
        {{-- center side --}}
        <td>
        <p data-id="{{ $user->id }}" data-type="user">
            @php
                $hide_script = strlen(strip_tags($user->name)) > 25 ? '...' : '';
            @endphp
            {{ substr(strip_tags($user->name),0, 25). $hide_script }}
            <span>{{ $lastMessage->created_at->diffForHumans() }}</span></p>
        <span>
            {{-- Last Message user indicator --}}
            {!!
                $lastMessage->from_id == Auth::user()->id
                ? '<span class="lastMessageIndicator">Bạn :</span>'
                : ''
            !!}
            {{-- Last message body --}}
            @if($lastMessage->attachment == null)
            {!!
                strlen($lastMessage->body) > 30
                ? trim(substr($lastMessage->body, 0, 30)).'..'
                : $lastMessage->body
            !!}
            @else
            <span class="fas fa-file"></span> File đính kèm
            @endif
        </span>
        {{-- New messages counter --}}
            {!! $unseenCounter > 0 ? "<b>".$unseenCounter."</b>" : '' !!}
        </td>

    </tr>
</table>
@endif

{{-- -------------------- Search Item -------------------- --}}
@if($get == 'search_item')
<table class="messenger-list-item" data-contact="{{ $user->id }}">
    @php
        $url_image = $user->avatar;
        $url_image = str_replace('http://localhost/', config('app.url_image'), $url_image);
    @endphp
    <tr data-action="0">
        {{-- Avatar side --}}
        <td>
        <div class="avatar av-m"
        style="background-image: url('{{ $url_image }}');">
        </div>
        </td>
        {{-- center side --}}
        <td>
            <p data-id="{{ $user->id }}" data-type="user">
            {{ strlen($user->name) > 25 ? trim(substr($user->name,0,25)).'..' : $user->name }}
        </td>

    </tr>
</table>
@endif

{{-- -------------------- Shared photos Item -------------------- --}}
@if($get == 'sharedPhoto')
<div class="shared-photo chat-image" style="background-image: url('{{ str_replace('http://localhost/', config('app.url_image'), $image) }}')"></div>
@endif


