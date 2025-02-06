<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

@extends('products.layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                     @if(session('api_token'))

                     <div class="card shadow-lg border-0">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="m-0">Ürünler Listesi</h4>
                            <div class="header-buttons d-flex gap-2">
                                <a href="{{ url('products/create') }}" class="btn btn-light text-primary fw-bold">+ Ürün Ekle</a>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger fw-bold">Çıkış Yap</button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-hover table-bordered text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Ürün Adı</th>
                                        <th>Fiyat</th>
                                        <th>Açıklama</th>
                                        <th>Eylem</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td><strong>{{ $product['id'] }}</strong></td>
                                        <td>{{ $product['name'] }}</td>
                                        <td><span class="badge bg-success fs-6">{{ $product['price'] }} ₺</span></td>
                                        <td class="text-muted">{{ $product['description'] }}</td>
                                        <td class="d-flex justify-content-center gap-2">
                                            <!-- 🔍 Detay Butonu -->
                                            <a href="{{ route('products.show', $product['id']) }}" class="btn btn-sm btn-info">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </a>

                                            <!-- ✏️ Düzenle Butonu -->
                                            <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <!-- 🗑️ Sil Butonu -->
                                            <form action="{{ route('products.destroy', $product['id']) }}" method="POST" onsubmit="return confirmDelete();">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

<script>
    function confirmDelete() {
        return confirm("Bu ürünü silmek istediğinizden emin misiniz?");
    }
</script>

<style>
.header-buttons {
    display: flex;
    gap: 20px;
    justify-content: flex-end;
    align-items: flex-start;
}

.header-buttons .btn {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    padding: 10px 20px;
    font-size: 16px;
}

.pagination {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
}

@media (max-width: 576px) {
    .header-buttons {
        flex-direction: column;
        align-items: stretch;
        margin-top: 20px;
    }

    .header-buttons .btn {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        margin-bottom: 10px;
    }
}

@media (min-width: 577px) {
    .header-buttons .btn {
        width: auto;
        padding: 10px 20px;
        font-size: 16px;
    }
}

td form {
    display: inline-block;
    margin: 0;
}

td .btn {
    margin-right: 5px; /* Butonlar arasında mesafe */
}
</style>
