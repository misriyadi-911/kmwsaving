<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Pemberitahuan Pembayaran Gagal</title>
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
    <h1>Pemberitahuan Pembayaran Gagal</h1>
    <p style="color: black">Mohon maaf, pembayaran Anda telah ditolak atau gagal diproses.</p>

    <div class="status">
      <p style="color: black">Status Pembayaran: <strong>GAGAL</strong></p>
      <p style="color: black">Invoice ID: <strong>{{ $invoice_id }}</strong></p>
      <p style="color: black">Nominal Pembayaran: <strong>Rp. {{ $nominal }}</strong></p>
      <p style="color: black">Metode Pembayaran: <strong>{{ $metode_pembayaran }}</strong></p>
      <p style="color: black">Waktu Pembayaran: <strong>{{ $waktu_pembayaran }}</strong></p>
    </div>
    <h2>Alasan Pembayaran Gagal:</h2>
    <p>{{ $alasan }}</p>

    <h2>Catatan:</h2>
    <ul>
      <li>Anda dapat mencoba kembali melakukan pembayaran.</li>
      <li>Jika ada pertanyaan atau kebingungan, jangan ragu untuk menghubungi kami.</li>
    </ul>

    <p>Harap periksa kembali informasi yang Anda masukkan dan coba lagi.</p>

    <h2>Kontak Kami</h2>
    <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami:</p>
    <ul class="contact-info">
      <li>Email: officialkmw@gmail.com</li>
      <li>Telepon: +1345123</li>
    </ul>
  </div>
</body>
</html>
