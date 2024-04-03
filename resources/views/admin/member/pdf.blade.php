<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hóa đơn mua hàng</title>
  <style>
    /* CSS styles for the invoice */
    body {
      font-family: Arial, sans-serif;
    }
    .invoice {
      width: 100%;
      margin: 0 auto;
      padding: 20px;
      border-radius: 15px;
      background-color: white;
    }
    .invoice-header,
    .invoice-body,
    .invoice-footer {
      margin-bottom: 20px;
    }
    .invoice-header {
      text-align: center;
    }
    .invoice-header h2 {
      text-align: center;
      color: #df3c67;
    }
    .invoice-body table {
      width: 100%;
      border-collapse: collapse;
    }
    .invoice-body th {
        color: #df3c67;
    }
    .invoice-body th,
    .invoice-body td {
      border: 1px solid rgb(229, 229, 229);
      padding: 8px;
    }
    .invoice-footer {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="invoice">
    <div class="invoice-header">
        {!! $qr_code !!}
    </div>
    <div class="invoice-body">
      <table>
        <thead>
          <tr>
            <th>Member code</th>
            <th>Member name</th>
            <th>Member email</th>
            <th>Member phone</th>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td align="left">{{ $member->code }}</td>
                <td align="right">{{$member->name}}</td>
                <td align="right">{{$member->email}}</td>
                <td align="right">{{$member->phone}}</td>
            </tr>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</body>
</html>

