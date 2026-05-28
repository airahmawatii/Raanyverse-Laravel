<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perjanjian Sewa</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #b75c1c; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 28px; font-weight: bold; color: #3e342f; margin-bottom: 5px; }
        .logo span { color: #b75c1c; }
        .subtitle { font-size: 12px; color: #777; text-transform: uppercase; letter-spacing: 2px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; text-decoration: underline; margin-bottom: 30px; }
        .content { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .table th { background-color: #f9f9f9; width: 35%; }
        .signature-area { margin-top: 50px; width: 100%; }
        .signature-box { width: 45%; display: inline-block; text-align: center; }
        .signature-line { margin-top: 80px; border-top: 1px solid #333; width: 80%; margin-left: auto; margin-right: auto; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">Raany<span>Prop</span> Enterprise</div>
        <div class="subtitle">Sistem Manajemen Properti & Real Estate Terpadu</div>
    </div>

    <div class="title">SURAT PERJANJIAN SEWA MENYEWA PROPERTI</div>

    <div class="content">
        <p>Pada hari ini, <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>, kami yang bertanda tangan di bawah ini:</p>
        
        <table class="table">
            <tr>
                <th>Nama Pihak Pertama (Pemilik/Manajemen)</th>
                <td>Raanyverse Property Management</td>
            </tr>
            <tr>
                <th>Nama Pihak Kedua (Penyewa)</th>
                <td><strong>{{ $booking->tenant->name }}</strong></td>
            </tr>
            <tr>
                <th>Email Pihak Kedua</th>
                <td>{{ $booking->tenant->email }}</td>
            </tr>
        </table>

        <p>Pihak Pertama setuju untuk menyewakan kepada Pihak Kedua, dan Pihak Kedua setuju untuk menyewa dari Pihak Pertama, sebuah unit properti dengan rincian sebagai berikut:</p>

        <table class="table">
            <tr>
                <th>Kawasan / Cluster</th>
                <td>{{ $booking->unit->estate->name ?? 'Enterprise Estate' }}</td>
            </tr>
            <tr>
                <th>Nama Unit / Blok</th>
                <td><strong>{{ $booking->unit->name }}</strong> (Blok: {{ $booking->unit->blok }}, No: {{ $booking->unit->nomor_unit }})</td>
            </tr>
            <tr>
                <th>Tipe Properti</th>
                <td style="text-transform: capitalize;">{{ $booking->unit->property_type }} - {{ $booking->unit->type }}</td>
            </tr>
            <tr>
                <th>Masa Sewa</th>
                <td><strong>{{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('d F Y') }}</strong></td>
            </tr>
            <tr>
                <th>Harga Sewa per Bulan</th>
                <td>Rp {{ number_format($booking->unit->price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <p>Dengan ketentuan-ketentuan yang diatur dalam peraturan tata tertib kawasan yang mengikat secara hukum. Pihak Kedua diwajibkan melakukan pembayaran sesuai dengan tagihan yang diterbitkan oleh sistem manajemen.</p>
    </div>

    <div class="signature-area">
        <div class="signature-box">
            <p>Pihak Pertama</p>
            <div class="signature-line">Manajemen RaanyProp</div>
        </div>
        <div class="signature-box">
            <p>Pihak Kedua</p>
            <div class="signature-line">{{ $booking->tenant->name }}</div>
        </div>
    </div>

</body>
</html>
