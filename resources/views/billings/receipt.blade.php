<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KUITANSI - BILL-{{ $billing->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            color: #3e342f;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.6;
        }
        .receipt-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #e7e5e4;
            padding: 40px;
            border-radius: 20px;
            background: #ffffff;
        }
        .header {
            border-bottom: 2px solid #b75c1c;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header table {
            width: 100%;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #b75c1c;
            letter-spacing: 1px;
        }
        .logo span {
            color: #3e342f;
        }
        .title {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            color: #78716c;
            letter-spacing: 2px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 6px 0;
            vertical-align: top;
        }
        .info-table .label {
            color: #78716c;
            font-weight: bold;
            width: 120px;
        }
        .info-table .value {
            font-weight: 600;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .details-table th {
            background-color: #fdfbf7;
            border-bottom: 2px solid #e7e5e4;
            color: #78716c;
            font-weight: bold;
            text-align: left;
            padding: 12px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .details-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #f5f5f4;
        }
        .total-row td {
            border-top: 2px solid #e7e5e4;
            font-weight: bold;
            font-size: 16px;
        }
        .footer-table {
            width: 100%;
            margin-top: 50px;
        }
        .footer-table td {
            vertical-align: middle;
        }
        .qr-section {
            width: 50%;
            text-align: left;
        }
        .qr-box {
            display: inline-block;
            text-align: center;
            border: 1px solid #e7e5e4;
            padding: 10px;
            border-radius: 12px;
            background: #fdfbf7;
        }
        .qr-box img {
            width: 110px;
            height: 110px;
            display: block;
        }
        .qr-box span {
            font-size: 9px;
            color: #78716c;
            display: block;
            margin-top: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .signature-section {
            width: 50%;
            text-align: right;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
        }
        .signature-title {
            color: #78716c;
            font-size: 12px;
            margin-bottom: 60px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
        }
        .signature-name {
            font-weight: bold;
            border-bottom: 1px solid #3e342f;
            padding-bottom: 5px;
            display: inline-block;
            width: 180px;
        }
        .badge-lunas {
            display: inline-block;
            background-color: #d1fae5;
            color: #059669;
            border: 1px solid #a7f3d0;
            padding: 6px 15px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="receipt-box">
    <div class="header">
        <table>
            <tr>
                <td class="logo">
                    Prop<span>Verse</span>
                </td>
                <td class="title">
                    KUITANSI RESMI
                </td>
            </tr>
        </table>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">No. Kuitansi</td>
            <td class="value">: KUI-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</td>
            <td class="label" style="text-align: right; width: 150px;">Tanggal Bayar</td>
            <td class="value" style="text-align: right;">: {{ $billing->updated_at->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Penyewa</td>
            <td class="value">: {{ $billing->tenant->name }}</td>
            <td class="label" style="text-align: right; width: 150px;">Status Pembayaran</td>
            <td class="value" style="text-align: right;">: <span class="badge-lunas">LUNAS</span></td>
        </tr>
        <tr>
            <td class="label">Unit Hunian</td>
            <td class="value">: {{ $billing->unit->name }} ({{ ucfirst($billing->unit->type) }})</td>
            <td class="label" style="text-align: right; width: 150px;">Metode Pembayaran</td>
            <td class="value" style="text-align: right;">: {{ strtoupper($billing->payment_type ?? 'Midtrans/Gateway') }}</td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Deskripsi Item</th>
                <th style="text-align: right;">Periode</th>
                <th style="text-align: right;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sewa Hunian Properti {{ $billing->unit->name }}</td>
                <td style="text-align: right;">{{ $billing->period }}</td>
                <td style="text-align: right;">Rp {{ number_format($billing->amount, 0, ',', '.') }}</td>
            </tr>
            @if(($billing->admin_fee ?? 0) > 0)
            <tr>
                <td>Biaya Administrasi</td>
                <td style="text-align: right;">-</td>
                <td style="text-align: right;">Rp {{ number_format($billing->admin_fee, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($billing->fine_amount > 0)
            <tr>
                <td style="color: #dc2626; font-weight: bold;">Denda Keterlambatan Pembayaran</td>
                <td style="text-align: right; color: #dc2626;">-</td>
                <td style="text-align: right; color: #dc2626; font-weight: bold;">Rp {{ number_format($billing->fine_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td colspan="2" style="text-align: right; padding-right: 12px;">Total Pembayaran</td>
                <td style="text-align: right; color: #b75c1c;">Rp {{ number_format($billing->amount + ($billing->admin_fee ?? 0) + ($billing->fine_amount ?? 0), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td class="qr-section">
                <div class="qr-box">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('billings.verify', $billing->id)) }}" alt="QR Code Verification">
                    <span>Scan untuk Validasi</span>
                </div>
            </td>
            <td class="signature-section">
                <div class="signature-box">
                    <div class="signature-title">Pengelola Kawasan</div>
                    <div class="signature-name">PropVerse Management</div>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
