@extends('layouts.app')

@section('content')

<div class="container text-center mt-5">

    <h3>💳 Pembayaran</h3>

    <button id="pay-button" class="btn btn-success mt-3">
        Bayar Sekarang
    </button>

</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            alert("Pembayaran sukses");
            window.location.href = "/kasir";
        },
        onPending: function(result){
            alert("Menunggu pembayaran");
        },
        onError: function(result){
            alert("Pembayaran gagal");
        }
    });
};
</script>

@endsection