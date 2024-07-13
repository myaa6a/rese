@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="mypage__ttl-container">
    <h2 class="mypage__ttl">{{ $user->name }}さん</h2>
</div>

<div class="mypage__content">
    <div class="reservation__container">
        <h3 class="reservation-container__ttl">予約状況</h3>
        @foreach($reservations as $index => $reservation)
        @if((($reservation->date==$today) && ($reservation->time>$now)) || ($reservation->date>$today))
        <div class="reservation__content">
            <div class="reservation__flex">
                <div class="reservation__content-ttl">
                    <h4>予約{{$index + 1}}</h4>
                </div>
                <div class="reservation__delete">
                    <form class="reservation__delete-form" action="/reservation_delete" method="post">
                    @method('DELETE')
                    @csrf
                        <input class="reservation__delete-input" type="hidden" name="id" value="{{$reservation->id}}">
                        <button class="reservation__delete-btn" type="submit"></button>
                    </form>
                </div>
            </div>
            <div class="reservation__content-table">
                <table class="reservation__table">
                    <tr class="reservation__row">
                        <th class="reservation__label">Shop</th>
                        <td class="reservation__data">{{ $reservation->shop->shop_name }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Date</th>
                        <td class="reservation__data">{{ $reservation->date }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Time</th>
                        <td class="reservation__data">{{ substr($reservation->time, 0, 5) }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Number</th>
                        <td class="reservation__data">{{ $reservation->number }}</td>
                    </tr>
                </table>
            </div>
            <div class="reservation-update">
                <a class="reservation-update__btn" href="#{{$reservation->id}}">予約を変更する</a>
            </div>
            <!--予約変更モーダル-->
            <div class="modal" id="{{$reservation->id}}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal__inner">
                    <div class="modal__content">
                        <div class="modal__ttl">
                            <h4>予約の変更</h4>
                        </div>
                        <div class="modal-reservation__content-table">
                            <table class="modal-reservation__table">
                                <form class="modal-reservation__update-form" action="/reservation_update" method="POST">
                                @method('PATCH')
                                @csrf
                                    <tr class="modal-reservation__row">
                                        <th class="modal-reservation__label">Shop</th>
                                        <td class="modal-reservation__data">{{ $reservation->shop->shop_name }}</td>
                                    </tr>
                                    <tr class="modal-reservation__row">
                                        <th class="modal-reservation__label">Date</th>
                                        <td class="modal-reservation__data">
                                            <input class="modal-reservation__update-input" type="date"  min="{{$tomorrow}}" name="date" value="{{ $reservation->date }}">
                                        </td>
                                        <div class="form__error__container">
                                            <div class="form__error">
                                                @error('date')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </tr>
                                    <tr class="modal-reservation__row">
                                        <th class="modal-reservation__label">Time</th>
                                        <td class="modal-reservation__data-select">
                                            <select id="select_time" name="time">
                                                <option selected>{{ substr($reservation->time, 0, 5) }}</option>
                                                <option value="17:00">17:00</option>
                                                <option value="17:30">17:30</option>
                                                <option value="18:00">18:00</option>
                                                <option value="18:30">18:30</option>
                                                <option value="19:00">19:00</option>
                                                <option value="19:30">19:30</option>
                                                <option value="20:00">20:00</option>
                                            </select>
                                        </td>
                                        <div class="form__error__container">
                                            <div class="form__error">
                                                @error('time')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </tr>
                                    <tr class="modal-reservation__row">
                                        <th class="modal-reservation__label">Number</th>
                                        <td class="modal-reservation__data-select">
                                            <select id="select_number" name="number">
                                                <option selected>{{ $reservation->number }}</option>
                                                <option value="1人">1人</option>
                                                <option value="2人">2人</option>
                                                <option value="3人">3人</option>
                                                <option value="4人">4人</option>
                                                <option value="5人">5人</option>
                                            </select>
                                        </td>
                                        <div class="form__error__container">
                                            <div class="form__error">
                                                @error('number')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </tr>
                                </table>
                                <div class="modal-form__button">
                                    <input type="hidden" name="id" value="{{ $reservation->id }}">
                                    <button class="modal-form__button-submit" type="submit">変更する</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="#" class="modal__close-btn">×</a>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @foreach($visits as $visit)
        @if((($visit->date==$today) && ($visit->time<=$now)) || ($visit->date<$today))
        <div class="visit__content">
            <div class="visit__content-ttl">
                <h4>来店済み</h4>
            </div>
            <div class="reservation__content-table">
                <table class="reservation__table">
                    <tr class="reservation__row">
                        <th class="reservation__label">Shop</th>
                        <td class="reservation__data">{{ $visit->shop->shop_name }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Date</th>
                        <td class="reservation__data">{{ $visit->date }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Time</th>
                        <td class="reservation__data">{{ substr($visit->time, 0, 5) }}</td>
                    </tr>
                    <tr class="reservation__row">
                        <th class="reservation__label">Number</th>
                        <td class="reservation__data">{{ $visit->number }}</td>
                    </tr>
                </table>
            </div>
            @php
                $review = App\Models\Review::where('user_id',$user->id)->where('shop_id',$visit->shop->id)->first();
            @endphp
            @if(empty($review))
            <div class="review">
                <a class="review__btn" href="#{{$visit->shop_id}}">レビューを投稿する</a>
            </div>
            <!--レビュ投稿ーモーダル-->
            <div class="modal" id="{{$visit->shop_id}}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal__inner">
                    <div class="modal__content">
                        <div class="modal__ttl">
                            <h4>お店のレビュー</h4>
                        </div>
                        <form class="review-form__form" id="form" action="/review" method="POST">
                        @csrf
                            <table class="modal-review__table">
                                <tr class="modal-review__row">
                                    <th class="modal-review__label">評価点</th>
                                    <td class="modal-review__data">
                                        <div class="stars">
                                            <span>
                                                <input type="radio" name="star" value="5" id="{{$visit->shop_id}}_star1">
                                                    <label for="{{$visit->shop_id}}_star1">★</label>
                                                <input type="radio" name="star" value="4" id="{{$visit->shop_id}}_star2">
                                                    <label for="{{$visit->shop_id}}_star2">★</label>
                                                <input type="radio" name="star" value="3" id="{{$visit->shop_id}}_star3">
                                                    <label for="{{$visit->shop_id}}_star3">★</label>
                                                <input type="radio" name="star" value="2" id="{{$visit->shop_id}}_star4">
                                                    <label for="{{$visit->shop_id}}_star4">★</label>
                                                <input type="radio" name="star" value="1" id="{{$visit->shop_id}}_star5">
                                                    <label for="{{$visit->shop_id}}_star5">★</label>
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                <div class="form__error__container">
                                    <div class="form__error">
                                        @error('star')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <tr class="modal-review__row">
                                    <th class="modal-review__label">コメント</th>
                                    <td class="modal-review__data">
                                        <textarea name="comment" cols="35" rows="9" value="{{ old('comment') }}" placeholder="10文字以上入力してください"></textarea>
                                    </td>
                                </tr>
                                <div class="form__error__container">
                                    <div class="form__error">
                                        @error('comment')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </table>
                            <div class="modal-form__button">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="shop_id" value="{{ $visit->shop->id }}">
                                <button class="modal-form__button-submit" id='form_submit' type="submit">投稿する</button>
                            </div>
                        </form>
                    </div>
                    <a href="#" class="modal__close-btn">×</a>
                </div>
            </div>
            @else
            <a></a>
            @endif
        </div>
    @endif
    @endforeach
    </div>

    <div class="favorite__container">
        <h3 class="favorite-container__ttl">お気に入り店舗</h3>
        <div class="card__container">
            @foreach($favorites as $favorite)
            <div class="card">
                <div class="card__img">
                    <img src="{{ $favorite->shop->image }}" alt="shop_image" />
                </div>
                <div class="card__content">
                    <div class="card__content-top">
                        <h3 class="card__content-ttl">
                                {{ $favorite->shop->shop_name }}
                            </h3>
                        <div class="card__content-review">
                            @php
                                $star_avg = App\Models\Review::where('shop_id',$favorite->shop_id)->avg('star');
                                $star_avg = substr($star_avg, 0, 4);
                                $review_count = App\Models\Review::where('shop_id',$favorite->shop_id)->count();
                            @endphp
                            <div class="review__star">
                                @if(empty($star_avg))
                                    <span class="star star0"></span>
                                @elseif($star_avg >= 1 && $star_avg <= 1.4)
                                    <span class="star star1"></span>
                                @elseif($star_avg >= 1.5 && $star_avg < 2)
                                    <span class="star star1-5"></span>
                                @elseif($star_avg >= 2 && $star_avg <= 2.4)
                                    <span class="star star2"></span>
                                @elseif($star_avg >= 2.5 && $star_avg < 3)
                                    <span class="star star2-5"></span>
                                @elseif($star_avg >= 3 && $star_avg <= 3.4)
                                    <span class="star star3"></span>
                                @elseif($star_avg >= 3.5 && $star_avg < 4)
                                    <span class="star star3-5"></span>
                                @elseif($star_avg >= 4 && $star_avg <= 4.4)
                                    <span class="star star4"></span>
                                @elseif($star_avg >= 4.5 && $star_avg < 5)
                                    <span class="star star4-5"></span>
                                @elseif($star_avg == 5)
                                    <span class="star star5"></span>
                                @endif
                            </div>
                            @if($review_count == 0)
                                <p class="review__count">(0件)</p>
                            @else
                                <p class="star__avg">{{$star_avg}}</p>
                                <a class="review__count" href="#{{$favorite->id}}">({{$review_count}}件)</a>
                            @endif
                        </div>
                    </div>
                    <div class="card__content-tag">
                        <p class="card__content-tag-item">#{{ $favorite->shop->area->area_name }}</p>
                        <p class="card__content-tag-item card__content-tag-item--last">
                            #{{ $favorite->shop->genre->genre_name }}
                        </p>
                    </div>
                    <div class="card__content-btn">
                        <form class="shop-detail__form" action="/detail/{shop_id}" method="get">
                        @csrf
                            <input class="shop-detail__input" type="hidden" name="id" value="{{ $favorite->shop->id }}">
                            <button class="shop-detail__btn" type="submit">詳しくみる</button>
                        </form>
                        <form class="favorite__form" action="/favorite_delete" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="shop_id" value="{{ $favorite->shop->id }}">
                            <button class="favorite__btn" type="submit"></button>
                        </form>
                    </div>
                </div>
            </div>
            <!--レビュ一覧ーモーダル-->
            <div class="modal" id="{{$favorite->id}}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal__inner">
                    <div class="modal-review__content">
                        <a href="#" class="modal__close-btn">×</a>
                        <h4 class="modal__ttl">お店のレビュー</h4>
                        @foreach($reviews as $review)
                        @if($review->shop_id == $favorite->shop_id)
                        <div class="review__content">
                            <table class="modal-review-all__table">
                                <tr class="modal-review-all__row">
                                    <th class="modal-review__label">投稿者</th>
                                    <td class="modal-review__data">{{$review->user->name}}</td>
                                </tr>
                                <tr class="modal-review-all__row">
                                    <th class="modal-review__label">評価点</th>
                                    <td class="modal-review__data">
                                        <div class="review__star">
                                        @if($review->star == 1)
                                            <span class="yellow-star">★</span><span class="gray-star">★★★★</span>
                                        @elseif($review->star == 2)
                                            <span class="yellow-star">★★</span><span class="gray-star">★★★</span>
                                        @elseif($review->star == 3)
                                            <span class="yellow-star">★★★</span><span class="gray-star">★★</span>
                                        @elseif($review->star == 4)
                                            <span class="yellow-star">★★★★</span><span class="gray-star">★</span>
                                        @elseif($review->star == 5)
                                            <span class="yellow-star">★★★★★</span>
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr class="modal-review-all__row">
                                    <th class="modal-review__label">コメント</th>
                                    <td class="modal-review__data">{{$review->comment}}</td>
                                </tr>
                            </table>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection