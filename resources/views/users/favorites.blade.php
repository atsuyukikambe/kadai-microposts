@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            {{-- ユーザ情報 --}}
            @include('users.card')
        </aside>
        <div class="col-sm-8">
            {{-- タブ --}}
            @include('users.navtabs')
            {{-- お気に入り一覧 --}}
            @if (count($microposts) > 0)
            <ul class="list-unstyled">
                @foreach ($microposts as $micropost)
                    <div class="media-body">
                    {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                    <img class="mr-2 rounded" src="{{ Gravatar::get($user->email, ['size' => 50]) }}" alt="">
                        <div>
                            {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                            {!! link_to_route('users.show', $micropost->user->name, ['user' => $micropost->user->id]) !!}
                            <!--<a href="{{ route('users.show', [$micropost->user->id]) }}">{{ $micropost->user->name }}</a>-->
                            <span class="text-muted">posted at {{ $micropost->created_at }}</span>
                        </div>
                        <div>                                
                            {{-- 投稿内容 --}}
                            <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                        </div>
                        <div class="mt-4 row">
                            <div class='col-sm-3'>
                                {{-- 投稿のお気に入りに登録ボタンのフォーム --}}
                                @include('user_favorite.favorite_button')
                            </div>
                            <div class="col-sm-3">
                                @if(Auth::id() == $user->id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>
                {{-- ページネーションのリンク --}}
                {{ $microposts->links() }}
            @endif
        </div>
    </div>
@endsection