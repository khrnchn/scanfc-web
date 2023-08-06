<center>
    <div class="container">
        @if ($record->exemption_file)
            <img src="https://scanfc-uitm.mahirandigital.com/exemption/serve/{{ $record->exemption_file }}" alt="Exemption Image">

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
