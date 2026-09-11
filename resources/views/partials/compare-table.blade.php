{{-- $other: competitor name; $rows: list of [label, kithara, other] --}}
<div class="table-wrap">
    <table class="compare compare-vs">
        <thead>
            <tr><th scope="col"></th><th scope="col">Kithara</th><th scope="col">{{ $other }}</th></tr>
        </thead>
        <tbody>
            @foreach ($rows as [$label, $kithara, $theirs])
                <tr>
                    <th scope="row">{{ $label }}</th>
                    <td>{{ $kithara }}</td>
                    <td>{{ $theirs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<p class="compare-note">Checked against each app's own listing and documentation in September 2026. Apps change; if something here is out of date, <a href="{{ route('contact') }}">tell us</a> and we will fix it.</p>
