<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Status Pembayaran</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
      color: black;
    }
    .container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    .status {
      font-size: 18px;
      margin-bottom: 20px;
    }
    p {
      margin-bottom: 10px;
    }
    ul {
      margin-bottom: 20px;
    }
    ul li {
      list-style-type: disc;
      margin-left: 20px;
    }
    h2 {
      margin-top: 20px;
    }
    ul.contact-info {
      list-style-type: none;
      padding: 0;
    }
    ul.contact-info li {
      margin-bottom: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Status Pembayaran</h1>
    <p style="color: black">Terima kasih telah melakukan pembayaran kepada kami. Berikut adalah detail status pembayaran Anda:</p>

    <div class="status">
      <p style="color: black">Status Pembayaran: <strong>{{ $status_pembayaran }}</strong></p>
      <p style="color: black">Invoice ID: <strong>{{ $invoice_id }}</strong></p>
      <p style="color: black">Nominal Pembayaran: <strong>Rp. {{ $nominal }}</strong></p>
      <p style="color: black">Metode Pembayaran: <strong>{{ $metode_pembayaran }}</strong></p>
      <p style="color: black">Waktu Pembayaran: <strong>{{ $waktu_pembayaran }}</strong></p>
      <p style="color: black">Total Saldo: <strong>Rp. {{ $total_saldo }}</strong></p>
    </div>
    <h2>Catatan: </h2>
    <ul>
      <li>Status pembayaran dapat berubah setelah proses verifikasi dari tim kami.</li>
      <li>Jika ada masalah atau pertanyaan, jangan ragu untuk menghubungi kami.</li>
    </ul>

    <p>Harap simpan informasi ini sebagai referensi untuk transaksi Anda.</p>

    <h2>Kontak Kami</h2>
    <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami:</p>
    <ul class="contact-info">
      <li>Email: officialkmw@gmail.com</li>
      <li>Telepon: +1345123</li>
    </ul>
  </div>
</body>
</html>
