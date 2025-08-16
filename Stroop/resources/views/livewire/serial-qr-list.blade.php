<style>
    @media print {
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
         }

         table {
        width: 20%;
        border-collapse: collapse;
    }
    td {
        border: 1px solid #ccc;
        padding: 10px;
        vertical-align: top;
    }
    .barcode-container {
        width:15%;
        height: 80px;
        position: relative;
        font-family: Arial, sans-serif;
        border: 2px solid #ccc;
        padding: 20px;
        box-sizing: border-box;
        margin-bottom: 20px;
    }
    .barcode-container img.logo {
        position: absolute;
        top: 20px;
        left: 10px;
        width: 20px;
        height: auto;
    }
    .barcode-container img.symbol {
        position: absolute;
        top: 20px;
        left: 30px;
        width: 30px;
        height: auto;
    }
    .property-text {
        position: absolute;
        bottom: 20px;
        left: 20px;
        font-weight: bold;
        font-size: 6px;
    }
    .qr-code {
        position: absolute;
        top: 20px;
        right:10px;
        text-align: center;
    }
    .qr-code span.serial-number {
        font-weight: bold;
        display: block;
        margin-top: 8px;
        font-size: 6px;
    }
    }

    /* Screen styles */
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        border: 1px solid #ccc;
        padding: 10px;
        vertical-align: top;
    }
    .barcode-container {
    width:20%;
    height: 80px; /* print height */
    position: relative;
    font-family: Arial, sans-serif;
    border: 2px solid #ccc;
    background-color: white; /* added */
    padding: 20px;
    box-sizing: border-box;
    margin-bottom: 20px;}
    .barcode-container img.logo {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 20px;
        height: auto;
    }
    .barcode-container img.symbol {
        position: absolute;
        top: 10px;
        left: 30px;
        width: 50px;
        height: auto;
    }
    .property-text {
        position: absolute;
        bottom: 00px;
        left: 20px;
        font-weight: bold;
        font-size: 6px;
         color: black;
    }
    .qr-code {
        position: absolute;
        top: 10px;
        right:5px;
        text-align: center;
        
    }
    .qr-code span.serial-number {
        font-weight: bold;
        display: block;
        margin-top: 2px;
        bottom: 45px;
        font-size: 8px;
    }
</style>

<div>
   
            @foreach ($serialNumbers as $serial)
               
                        <div class="barcode-container">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="logo" />
                            <img src="{{ asset('images/akuna.png') }}" alt="Lightning Symbol" class="symbol" />

                            <div class="property-text">
                                Property of <br>
                                Sri Lanka Army - Signal Corps
                            </div>

                              @php
                                // human-readable lines (numbered)
                                $qrLines = [
                                    "1. Serial Number: " . ($serial->serial_number ?? 'N/A'),
                                    "2. Item Name: " . ($serial->item->item_name ?? 'N/A'),
                                    "3. Signal Unit: " . ($serial->signalUnit->sig_unit_name ?? 'N/A'),
                                    "4. Issue Place: " . ($serial->issuePlace->issue_place ?? 'N/A'),
                                    "5. Warranty Expiry Date: " . ($serial->item->warranty_expiry_date ?? 'N/A'),
                                ];

                                // join with newline for multiline QR content
                                $qrText = implode("\n", $qrLines);
                            @endphp

                            <div class="qr-code">
                                {!! QrCode::size(40)->generate($qrText) !!}
                                <span class="serial-number">{{ $serial->serial_number }}</span>
                            </div>
                        </div>
                   
                </tr>
            @endforeach
     
    <button onclick="window.print()" >
        Print 
    </button>
</div>
