@extends('products.layout')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('api_token'))

                    <div class="card">
                        <div class="card-header">
                            <h4>Ürün Oluştur
                                <a href="{{ url('products') }}" class="btn btn-danger float-end">Geri</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('products.store') }}" method="POST">
                                @csrf

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Hata mesajı -->
                                @if ($errors->any())

                                @endif

                                <div class="mb-3">
                                    <label>Ürün Adı</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"/>
                                    @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Ürün Fiyatı</label>
                                    <input type="text" name="price" class="form-control" value="{{ old('price') }}"/>
                                    @error('price') <span class="text-danger">{{$message}}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Ürün Açıklaması</label>
                                    <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                                    @error('description') <span class="text-danger">{{$message}}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                </div>

                            </form>
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
