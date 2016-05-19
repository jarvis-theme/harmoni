<section class="sectiondiv">
    <div class="row">
        <h2 class="title"><i class="icon-basket"></i> Detail Order</h2>
    </div>
    <div class="row">
        <div class="twelve columns section">
            <div class="table-responsive">
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
            </div>
            <div class="sep-bor"></div>
        </div>

        <div class="twelve columns section">
            @if($order->jenisPembayaran == 1 && $order->status == 0)
            <div class="seven columns respond push_two">
                <h4>{{trans('content.step5.confirm_btn')." ".trans('content.step3.transfer')}}</h4>
                <hr>
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
                        <button type="submit">{{trans('content.step5.confirm_btn')}}</button>
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
        <div class="twelve columns section pay">
            <center>
                <h3>{{trans('content.step5.confirm_btn')}} Paypal</h3><hr>
                <p>{{trans('content.step5.paypal')}}</p><br>
            </center>
            <center id="paypal">{{$paypalbutton}}</center>
            <br>
        </div>
        @elseif($order->jenisPembayaran==4) 
            @if(($checkouttype==1 && $order->status < 2) || ($checkouttype==3 && ($order->status!=6)))
            <div class="twelve columns section pay">
                <center>
                    <h3>{{trans('content.step5.confirm_btn')}} iPaymu</h3><hr>
                    <p>{{trans('content.step5.ipaymu')}}</p>
                    <a class="btn-payment" href="{{url('ipaymu/'.$order->id)}}" target="_blank">{{trans('content.step5.ipaymu_btn')}}</a>
                </center>
                <br>
                @endif
            </div>
        @elseif($order->jenisPembayaran==5 && $order->status == 0)
        <div class="twelve columns section pay">
            <center>
                <h3>{{trans('content.step5.confirm_btn')}} DOKU MyShortCart</h3><hr>
                <p>{{trans('content.step5.doku')}}</p>
                {{ $doku_button }}
            </center>
            <br>
        </div>
        @elseif($order->jenisPembayaran == 6 && $order->status == 0)
        <div class="twelve columns section pay">
            <center>
                <h3>{{trans('content.step5.confirm_btn')}} Bitcoin</h3><hr>
                <p>{{trans('content.step5.bitcoin')}}</p>
                {{$bitcoinbutton}}
            </center>
            <br>
        </div>
        @elseif($order->jenisPembayaran == 8 && $order->status == 0)
        <div class="twelve columns section pay">
            <center>
                <h3>{{trans('content.step5.confirm_btn')}} Veritrans</h3><hr>
                <p>{{trans('content.step5.veritrans')}}</p><br>
                <button class="btn-payment" onclick="location.href='{{ $veritrans_payment_url }}'">{{trans('content.step5.veritrans_btn')}}</button>
            </center>
            <br>
        </div>
        @endif
   </div>
</section>