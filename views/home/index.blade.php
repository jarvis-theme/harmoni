<section id="popular">
    <div class="row">
        <div class="twelve columns">
            <h3>Koleksi Produk Kami</h3>
            {{-- */ $val=0; /* --}}
            <div class="row">
                @foreach(home_product() as $products)
                <div class="four columns image photo product">
                    <a href="{{product_url($products)}}">
                        <img src="{{url(product_image_url($products->gambar1,'medium'))}}" alt="{{$products->nama}}">
                    </a>
                    <div class="product-detail">
                        <h4 class="title"><a href="{{product_url($products)}}">{{short_description($products->nama,27)}}</a></h4>
                        @if(is_outstok($products))
                        <span class="empty">KOSONG</span>
                        @elseif(is_terlaris($products))
                        <span class="sale">HOT</span>
                        @elseif(is_produkbaru($products))
                        <span class="new">BARU</span>
                        @endif
                        <span class="price">
                            @if(!empty($products->hargaCoret))
                            <del><span class="amount">{{price($products->hargaCoret)}}</span></del>
                            @endif
                            <ins><span class="amount">{{price($products->hargaJual)}}</span></ins>
                        </span>
                        <div class="btn btn-home">
                            <a href="{{product_url($products)}}">Lihat</a>
                        </div>
                    </div>
                </div>
                {{-- */ $val+=1; /* --}}
                    @if($val % 3 == 0 && $val != 0)
                    </div>
                    <div class="row">
                    @endif
                @endforeach
            </div>
            <div class="row">
                <div class="medium metro rounded btn home-collection">
                    <a href="{{url('produk')}}">Lihat Koleksi Produk</a>
                </div>
            </div>
        </div>
    </div>
</section>