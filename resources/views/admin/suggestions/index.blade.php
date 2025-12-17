<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Pesan</th>
            <th>Foto</th>
            <th>Status</th>
            <th>Publik</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->name ?? '-' }}</td>
                <td>{{ $item->message }}</td>
                <td>
                    @if ($item->photos)
                        @foreach ($item->photos as $img)
                            <img src="{{ asset('uploads/suggestions/' . $img) }}" width="60">
                        @endforeach
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $item->status == 'handled' ? 'success' : 'warning' }}">
                        {{ $item->status }}
                    </span>
                </td>
                <td>{{ $item->allow_public ? 'Ya' : 'Tidak' }}</td>
                <td>
                    <form action="/admin/suggestions/{{ $item->id }}/publish" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-sm btn-info">Toggle Publik</button>
                    </form>

                    <form action="/admin/suggestions/{{ $item->id }}/handled" method="POST" style="display:inline">
                        @csrf
                        <button class="btn btn-sm btn-success">Ditindaklanjuti</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
