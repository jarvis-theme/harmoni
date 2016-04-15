<section class="sectiondiv">
    <div class="row">
        <h2 class="title"><i class="icon-basket"></i> Detail Order</h2>
    </div>
    <div class="row">
        <div class="twelve columns section">
            <table>
                <thead>
                    <tr>
                        <th><span>Kode Order</span></th>
                        <th><span>Tanggal Order</span></th>
                        <th><span>Detail Order</span></th>
                        <th><span>Jumlah</span></th>
                        <th><span>No. Resi</span></th>
                        <th><span>Status</span></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ prefixOrder().$order->kodeOrder }}</td>
                        <td>{{ waktu($order->tanggalOrder) }}</td>
                        <td>
                            <ul>
                                @foreach ($order->detailorder as $detail)
                                <li class="detailorder">{{$detail->produk->nama}} {{$detail->opsiSkuId !=0 ? '('.$detail->opsisku['opsi1'].($detail->opsisku['opsi2'] != '' ? ' / '.$detail->opsisku['opsi2']:'').($detail->opsisku['opsi3'] !='' ? ' / '.$detail->opsisku['opsi3']:'').')':''}} - {{$detail->qty}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="quantity">{{ price($order->total) }}</td>
                        <td class="sub-price">{{ $order->noResi }}</td>
                        <td class="total-price">
                            @if($order->status==0)
                            <span class="label label-warning">Pending</span>
                            @elseif($order->status==1)
                            <span class="label label-primary">Konfirmasi diterima</span>
                            @elseif($order->status==2)
                            <span class="label label-info">Pembayaran diterima</span>
                            @elseif($order->status==3)
                            <span class="label label-success">Terkirim</span>
                            @elseif($order->status==4)
                            <span class="label label-default">Batal</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="sep-bor"></div>
        </div>

        <div class="twelve columns section">
            @if($order->jenisPembayaran == 1 && $order->status == 0)
            <div class="six columns respond">
                <h4>Konfirmasi Pembayaran</h4>
                {{Form::open(array('url'=> 'konfirmasiorder/'.$order->id, 'method'=>'put'))}} 
                    <ul>
                        <li class="field">
                            <label class="mheight"> Nama Pengirim:</label>
                            <input type="text" class="text input" id="search" name="nama" required="required">
                        </li>
                        <li class="field">
                            <label class="mheight"> No Rekening:</label>
                            <input type="text" class="text input" id="search" name="noRekPengirim" required="required">
                        </li>
                        <li class="field">
                            <label class="mheight"> Rekening Tujuan:</label>
                            <select name="bank" class="opsi" required="required">
                                <option value="">-- Pilih Bank Tujuan --</option>
                                @foreach (list_banks() as $bank)
                                <option value="{{$bank->id}}">{{$bank->bankdefault->nama}} - {{$bank->noRekening}} - A/n {{$bank->atasNama}}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="field">
                            <label class="mheight"> Jumlah:</label>
                            <input type="number" class="text input" id="search" placeholder="Jumlah transfer" name="jumlah" value="{{$order->total}}" required="required">
                        </li>
                    </ul>
                    <div class="medium primary btn">
                        <button type="submit">Konfirmasi</button>
                    </div>
                {{Form::close()}}
            </div>
            @endif
        </div>

        @if($paymentinfo!=null)
        <h3><center>Paypal Payment Details</center></h3><br>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Payment Status</td><td>:</td><td>{{$paymentinfo['payment_status']}}</td>
                    </tr>
                    <tr>
                        <td>Payment Date</td><td>:</td><td>{{$paymentinfo['payment_date']}}</td>
                    </tr>
                    <tr>
                        <td>Address Name</td><td>:</td><td>{{$paymentinfo['address_name']}}</td>
                    </tr>
                    <tr>
                        <td>Payer Email</td><td>:</td><td>{{$paymentinfo['payer_email']}}</td>
                    </tr>
                    <tr>
                        <td>Item Name</td><td>:</td><td>{{$paymentinfo['item_name1']}}</td>
                    </tr>
                    <tr>
                        <td>Receiver Email</td><td>:</td><td>{{$paymentinfo['receiver_email']}}</td>
                    </tr>
                    <tr>
                        <td>Total Payment</td><td>:</td><td>{{$paymentinfo['payment_gross']}} {{$paymentinfo['mc_currency']}}</td>
                    </tr>
                </table>
            </div>
          <p>Thanks you for your order.</p>
          <br>
        @endif 
      
        @if($order->jenisPembayaran==2)
            <h3><center>Konfirmasi Pembayaran Via Paypal</center></h3><br>
            <p>Silakan melakukan pembayaran dengan paypal Anda secara online via paypal payment gateway. Transaksi ini berlaku jika pembayaran dilakukan sebelum {{$expired}}. Klik tombol "Bayar Dengan Paypal" di bawah untuk melanjutkan proses pembayaran.</p>
            {{$paypalbutton}}
            <br>
        @elseif($order->jenisPembayaran==6)
            @if($order->status == 0)
            <h3><center>Konfirmasi Pembayaran Via Bitcoin</center></h3><br>
            <p>Silahkan melakukan pembayaran dengan bitcoin Anda secara online via bitcoin payment gateway. Transaksi ini berlaku jika pembayaran dilakukan sebelum <b>{{$expired_bitcoin}}</b>. Klik tombol "Pay with Bitcoin" di bawah untuk melanjutkan proses pembayaran.</p>
            {{$bitcoinbutton}}
            <br>
            @endif
        @endif
   </div>
</section>