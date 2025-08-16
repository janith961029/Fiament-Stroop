<x-filament-panels::page>
    <h2><b>Quantity Details For Item Name</b></h2>
    
    <p><strong>1.   Total Item Count:</strong> {{ $totalCount }}</p>
    <p><strong>2.   Received Item Count:</strong> {{ $receivedCount }}</p>
    <p><strong>3.   Issued Item Count:</strong> {{ $issuedCount }}</p>
   
    <h2><b>Quantity Details For Purchase Order</b></h2>





     <p><strong>Item Code:</strong> {{ $record->item_code }}</p>

  <table class="bg-black divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Serial Number</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Received</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Issued</th>
               
              
            </tr>
        </thead>
      <!--  <tbody class="bg-black divide-y divide-gray-200">
            @forelse ($serialNumbers as $serial)
                <tr class="hover:">
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $serial->serial_number }}</td>
                    <td class="px-4 py-2 text-sm">
                        @if ($serial->recieved)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Yes</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">No</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm">
                        @if (is_null($serial->issued))
                            <span class="text-gray-400">--</span>
                        @elseif ($serial->issued)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Yes</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">No</span>
                        @endif
                    </td>
                 
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 text-center text-gray-500">No serial numbers found.</td>
                </tr>
              @foreach ($serialNumbers as $serial)
            <tr>
              

             
            </tr>
        @endforeach
            @endforelse
        </tbody>
    </table>
  
<h2>Barcode Print Excel</h2>


   <table class="bg-black divide-y divide-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Serial Number</th>
                
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">End User</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Location</th>
                  <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Item Name</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Warrenty Expiry Date</th>
              
            </tr>
        </thead>
        <tbody class="bg-black divide-y divide-gray-200">
            @forelse ($serialNumbers as $serial)
                <tr class="hover:">
                    <td class="px-4 py-2 text-sm text-gray-400">{{ $serial->serial_number }}</td>
                   
                   <td class="px-4 py-2 text-sm ">{{ $serial->issue_place_name ?? 'N/A' }}</td>
                   <td class="px-4 py-2 text-sm ">{{ $serial->signal_unit_name ?? 'N/A' }}</td>
                    <td class="px-4 py-2 text-sm ">{{ $serial->item_name ?? 'N/A' }}</td>
                     <td class="px-4 py-2 text-sm ">{{ $serial->warranty_expiry_date ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-2 text-center text-gray-400">No serial numbers found.</td>
                </tr>
              @foreach ($serialNumbers as $serial)
            <tr>
              

             
            </tr>
        @endforeach
            @endforelse
        </tbody>
    </table><button wire:click="exportIssuedSerialNumbers" class="btn btn-primary">
    Export Issued Serial Numbers to Excel
</button>-->
</x-filament-panels::page>       