@extends('layouts.admin')

@section('content')

@include('admin.admins._styles')



<div class="header-box">
    <h2><i class="fa-solid fa-users-gear"></i> Manajemen Admin</h2>
    <a href="{{ route('admin.admins.create') }}" class="btn-tambah">
        <i class="fa fa-plus"></i> Tambah Admin
    </a>
</div>

<div class="table-box">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat Pada</th>
                    <th style="text-align:center;">Hapus</th>
                    <th style="text-align:center;">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ ($admins->currentPage() - 1) * $admins->perPage() + $loop->iteration }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="pgr-avatar-sm">
                                {{ strtoupper(substr($admin->name, 0, 2)) }}
                            </div>
                            {{ $admin->name }}
                            @if(Auth::id() == $admin->id)
                            <span style="background:#cfe2ff; color:#084298; padding:2px 8px; border-radius:10px; font-size:10px; font-weight:600;">Saya</span>
                            @endif
                        </div>
                    </td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <span style="background:{{ $admin->role == 'ketua' ? '#dcfce7' : '#f1f5f9' }}; color:{{ $admin->role == 'ketua' ? '#166534' : '#475569' }}; padding:4px 10px; border-radius:12px; font-size:12px; font-weight:600;">
                            {{ ucfirst($admin->role) }}
                        </span>
                    </td>
                    <td>{{ $admin->created_at->translatedFormat('d M Y') }}</td>
                    <td style="text-align:center;">
                        @if(Auth::id() != $admin->id)
                        <form action="{{ route('admin.admins.delete', $admin->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $admin->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDeleteAdmin({{ $admin->id }})" style="border:none; background:none; cursor:pointer; color:red;">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @else
                        <i class="fa fa-trash" style="color:#ccc;" title="Tidak dapat menghapus diri sendiri"></i>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.admins.edit', $admin->id) }}" style="color:blue;">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <x-pagination :paginator="$admins" item="admin" />
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDeleteAdmin(id) {
        Swal.fire({
            title: 'Hapus Admin?',
            text: "Data admin akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: @json(session('error'))
    });
</script>
@endif

@endsection