<center>
    <div class="container">
        @if ($record->exemption_file)
            <img src="http://127.0.0.1:8000/exemption/serve/{{ $record->exemption_file }}" alt="Exemption Image">

            @if ($record->exemption_remarks)
                <p>Remarks: {{ $record->exemption_remarks }}</p>
            @else
                <p>No remarks available.</p>
            @endif
        @else
            <p>Exemption not submitted yet.</p>
        @endif
    </div>
</center>
