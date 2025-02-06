@extends('products.layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('api_token'))
                    <div class="card">
                        <div class="card-header">
                            <h4>Ürün Detayını Göster
                                <a href="{{ url('products') }}" class="btn btn-danger float-end">Geri</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Ürün Adı</label>
                                <p>
                                    {{ $product['name'] }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Fiyat</label>
                                <p>
                                    {{ $product['price'] }}
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Açıklama</label>
                                <p>
                                    {!! $product['description'] !!}
                                </p>
                            </div>

                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning text-center mt-5">
                        <strong>Giriş yapmadan bu formu görüntüleyemezsiniz.</strong>
                        <a href='login' class="btn btn-primary mt-2">Giriş Yap</a>
                    </div>
                    @endif

            </div>
        </div>
    </div>


@endsection
