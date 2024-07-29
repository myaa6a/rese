@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shop-admin.css') }}">
@endsection

@section('content')
<div class="admin__ttl-container">
    <h2 class="admin__ttl">{{ $user->name }}さん</h2>
</div>

@if(session('message'))
    <div class="update__message">
        {{ session('message') }}
    </div>
@endif

@if(empty($shop_representative))
<div class="admin__content">
    <div class="shop__container">
        <div class="card">
            <div class="card__heading">
                <p>店舗情報の登録</p>
            </div>
            <div class="card__content">
                <form class="form" action="/editor/done" method="post">
                @csrf
                    <div class="form__group">
                        <div class="form__input">
                            <div class="form__label">店舗名:</div>
                            <input class="input" type="text" name="name" value="{{ old('name') }}" />
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__select">
                            <div class="form__label">地域:</div>
                            <select class="select" name="area_id">
                                <option disabled selected>選択して下さい</option>
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" @if(request('area')==$area->id) selected @endif>{{$area->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('area')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__select">
                            <div class="form__label">ジャンル:</div>
                            <select class="select" name="genre_id">
                                <option disabled selected>選択して下さい</option>
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" @if(request('genre')==$genre->id) selected @endif>{{$genre->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('area')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__text">
                            <div class="form__label">店舗概要:</div>
                            <textarea class="text__summary" name="summary" cols="30" rows="6">{{ old('summary') }}</textarea>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('summary')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__text">
                            <div class="form__label">画像URL:</div>
                            <textarea class="text__image" name="image" cols="30" rows="3">{{ old('image') }}</textarea>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('image')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__button">
                        <button class="form__button-submit" type="submit">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="check-reservation__container">
        <div class="check-reservation__ttl">
            <p>予約情報の確認</p>
        </div>
        <div class="check-reservation__content">
            <p>店舗情報を登録して下さい</p>
        </div>
    </div>
</div>
@else
<div class="admin__content">
    <div class="shop__container">
        <div class="card">
            <div class="card__heading">
                <p>店舗情報の更新</p>
            </div>
            <div class="card__content">
                <form class="form" action="/editor/update" method="post">
                @csrf
                    <div class="form__group">
                        <div class="form__input">
                            <div class="form__label">店舗名:</div>
                            <input class="input" type="text" name="name" value="{{ $shop_representative->shop->name }}" />
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__select">
                            <div class="form__label">地域:</div>
                            <select class="select" name="area_id">
                                <option disabled selected>{{ $shop_representative->shop->area->name }}</option>
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" @if(request('area')==$area->id) selected @endif>{{$area->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('area')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__select">
                            <div class="form__label">ジャンル:</div>
                            <select class="select" name="genre_id">
                                <option disabled selected>{{ $shop_representative->shop->genre->name }}</option>
                                @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" @if(request('genre')==$genre->id) selected @endif>{{$genre->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('area')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__text">
                            <div class="form__label">店舗概要:</div>
                            <textarea class="text__summary" name="summary" cols="30" rows="6">{{ $shop_representative->shop->summary }}</textarea>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('summary')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__text">
                            <div class="form__label">画像URL:</div>
                            <textarea class="text__image" name="image" cols="30" rows="3">{{ $shop_representative->shop->image }}</textarea>
                        </div>
                        <div class="form__error__container">
                            <div class="form__error">
                                @error('image')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__button">
                        <input type="hidden" name="id" value="{{ $shop_representative->shop->id }}">
                        <button class="form__button-submit" type="submit">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="check-reservation__container">
        <div class="check-reservation__ttl">
            <p>予約情報の確認</p>
        </div>
        <table class="reservation__table">
            <tr class="reservation__row">
                <th class="reservation__label">お名前</th>
                <th class="reservation__label">メールアドレス</th>
                <th class="reservation__label">日付</th>
                <th class="reservation__label">時間</th>
                <th class="reservation__label">人数</th>
            </tr>
            @foreach($reservations as $reservation)
            <tr class="reservation__row">
                <td class="reservation__data">{{$reservation->user->name}}</td>
                <td class="reservation__data">{{$reservation->user->email}}</td>
                <td class="reservation__data">{{$reservation->date}}</td>
                <td class="reservation__data">{{substr($reservation->time, 0, 5)}}</td>
                <td class="reservation__data">{{$reservation->number}}人</td>
            </tr>
            @endforeach
        </table>
        {{ $reservations->links('vendor.pagination.custom') }}
    </div>
</div>
@endif
@endsection