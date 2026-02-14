<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Quotation</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 14px; color: #1e293b; padding: 24px; }
    .letterhead { margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #cbd5e1; }
    .letterhead img { max-width: 200px; max-height: 70px; display: block; }
    h1 { font-size: 20px; margin: 0 0 20px; color: #0f172a; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    th, td { border: 1px solid #cbd5e1; padding: 10px 12px; text-align: left; }
    th { background: #f1f5f9; font-weight: 700; }
    .label { font-weight: 700; color: #475569; }
    .total { font-size: 16px; font-weight: 700; margin-top: 16px; }
    .footer { margin-top: 24px; font-size: 12px; color: #64748b; }
  </style>
</head>
<body>
  @if(!empty($logo_data_uri))
  <div class="letterhead">
    <img src="{{ $logo_data_uri }}" alt="Company logo">
  </div>
  @endif
  <h1>Quotation</h1>
  <p><span class="label">Country &amp; Service:</span> {{ $country }} – {{ $service }}</p>
  <p><span class="label">Quantity (kg):</span> {{ $qty }}</p>
  <table>
    <tr>
      <th>Description</th>
      <th>Unit price</th>
      <th>Qty (kg)</th>
      <th>Total</th>
    </tr>
    @if(!empty($dealer_applied))
    <tr>
      <td>Dealer total</td>
      <td>{{ number_format($dealer_unit_price, 2) }}</td>
      <td>{{ $qty }}</td>
      <td>{{ number_format($total_dealer, 2) }}</td>
    </tr>
    @else
    <tr>
      <td>Total</td>
      <td>{{ number_format($customer_unit_price, 2) }}</td>
      <td>{{ $qty }}</td>
      <td>{{ number_format($total_customer, 2) }}</td>
    </tr>
    @endif
  </table>
  <p class="footer">Generated on {{ $date }}. Unit price × qty (kg) = total.</p>
</body>
</html>
