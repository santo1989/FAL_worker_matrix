<table id="cashesTable" style="border: 1px solid #000; padding: 4px; border-collapse: collapse;">
    <thead style="border: 1px solid #000; padding: 4px;">
        <tr>
            <th colspan="13" style="text-align: center; border: none; vertical-align: middle;">
                {{-- <img src="{{ asset('images/assets/ntg_logo.png') }}" alt="Logo" style="height: 100px; width:50px;"> --}}
                <div style="font-size: 24px;">Northern Tosrifa Group</div>
                <div style="font-size: 10px;">Download Date: {{ Carbon\Carbon::now()->format('d-M-Y') }}</div>
            </th>
        </tr>
        <tr style="text-align: center;">
            <th style="border: 1px solid #000; padding: 4px;">Serial Number</th>
            <th style="border: 1px solid #000; padding: 4px;">Name</th>
            <th style="border: 1px solid #000; padding: 4px;">ID Card No</th>
            <th style="border: 1px solid #000; padding: 4px;">Date of Join</th>
            <th style="border: 1px solid #000; padding: 4px;">Present Grade</th>
            <th style="border: 1px solid #000; padding: 4px;">Proposed Grade</th>
            <th style="border: 1px solid #000; padding: 4px;">Floor</th>
            <th style="border: 1px solid #000; padding: 4px;">Line</th>
            <th style="border: 1px solid #000; padding: 4px;">Machine</th>
            <th style="border: 1px solid #000; padding: 4px;">Process Name</th>
            <th style="border: 1px solid #000; padding: 4px;">Achieve Pcs</th>
            <th style="border: 1px solid #000; padding: 4px;">Efficiency</th>
            <th style="border: 1px solid #000; padding: 4px;">Remarks</th>
        </tr>
    </thead>
    <tbody style="border: 1px solid #000; padding: 4px; text-align: center; vertical-align: middle;">
        @php $sl=0 @endphp
        @foreach ($search_worker as $spl)
            @php
                $data = DB::table('worker_sewing_process_entries')
                    ->where('worker_entry_id', $spl->id)
                    ->get();
                $machine_type = DB::table('sewing_process_lists')
                    ->whereIn('id', $data->pluck('sewing_process_list_id'))
                    ->get('machine_type');
            @endphp
            <tr style="text-align: center;">
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;">{{ ++$sl }}</td>
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;">
                    {{ $spl->employee_name_english }}</td>
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;">{{ $spl->id_card_no }}</td>
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;">
                    {{ Carbon\Carbon::parse($spl->joining_date)->format('d-M-Y') }}
                </td>
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;">{{ $spl->present_grade }}</td>
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;">{{ $spl->recomanded_grade }}
                </td>
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;">{{ $spl->floor }}</td>
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;">{{ $spl->line ?? '' }}</td>
                <td style="border: 1px solid #000; padding: 4px;">
                    <ol>
                        @foreach ($machine_type as $type)
                            <li>{{ $type->machine_type }}</li>
                        @endforeach
                    </ol>
                </td>
                <td style="border: 1px solid #000; padding: 4px;">
                    <ol>
                        @foreach ($data as $item)
                            <li>{{ ucwords($item->sewing_process_name) }}</li>
                        @endforeach
                    </ol>
                </td>
                <td style="border: 1px solid #000; padding: 4px;">
                    <ul>
                        @foreach ($data as $item)
                            <li>{{ number_format($item->achive_production, 2) }}</li>
                        @endforeach
                    </ul>
                </td>
                <td style="border: 1px solid #000; padding: 4px;">
                    <ul>
                        @foreach ($data as $item)
                            <li>{{ number_format($item->efficiency, 2) }}</li>
                        @endforeach
                    </ul>
                </td>
                <td style="border: 1px solid #000; padding: 4px; vertical-align: middle;"></td>
            </tr>
        @endforeach
    </tbody>
</table>
