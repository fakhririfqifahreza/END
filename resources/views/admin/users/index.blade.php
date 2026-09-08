@extends('layouts.admin')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-0" style="color: #550000;">
                <i class="bi bi-people-fill me-2"></i>Manajemen Akun Kasir & Admin
            </h3>
            <small class="text-muted">Kelola akun pengguna, reset kata sandi, dan hak akses sistem</small>
        </div>

        {{-- Tombol Tambah Akun HANYA MUNCUL UNTUK OWNER --}}
        @if(Auth::user()->isOwner())
            <button type="button" class="btn text-white fw-semibold px-3 py-2" style="background-color: #550000;" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Akun Baru
            </button>
        @endif
    </div>

    {{-- KARTU DAFTAR AKUN --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-3">
            <div class="row mb-3">
                <div class="col-md-5">
                    <form action="{{ route('admin.users.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted">
                            <th style="width: 60px;" class="text-center">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email / Username Login</th>
                            <th style="width: 130px;">Peran (Role)</th>
                            <th style="width: 120px;" class="text-center">Status</th>
                            <th style="width: 140px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center fw-semibold text-muted">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    @if($user->id === Auth::id())
                                        <span class="badge bg-light text-secondary border">Sedang Digunakan</span>
                                    @endif
                                </td>
                                <td class="text-muted">
                                    <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                                </td>
                                <td>
                                    @if(in_array($user->role, ['owner', 'pemilik_warung']))
                                        <span class="badge bg-danger px-2 py-1"><i class="bi bi-shield-lock me-1"></i>Owner</span>
                                    @else
                                        <span class="badge bg-primary px-2 py-1"><i class="bi bi-person me-1"></i>Kasir</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($user->is_active)
                                        <span class="badge bg-success px-2 py-1">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        {{-- Tombol Edit: Owner boleh edit semua akun; Kasir HANYA boleh edit akunnya sendiri --}}
                                        @if(Auth::user()->isOwner() || Auth::id() === $user->id)
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditUser{{ $user->id }}" title="Edit Akun">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif

                                        {{-- Tombol Hapus: HANYA OWNER yang bisa hapus (dan tidak bisa hapus akunnya sendiri) --}}
                                        @if(Auth::user()->isOwner() && $user->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun {{ $user->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Akun">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL EDIT USER --}}
                            @if(Auth::user()->isOwner() || Auth::id() === $user->id)
                                <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" style="color: #550000;">
                                                        <i class="bi bi-pencil-square me-1"></i>Edit Akun: {{ $user->name }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                                                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $user->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Email / Username</label>
                                                        <input type="email" name="email" class="form-control form-control-sm" value="{{ $user->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Kata Sandi Baru</label>
                                                        <input type="password" name="password" class="form-control form-control-sm" placeholder="Kosongkan jika tidak ingin mengganti kata sandi">
                                                        <small class="text-muted" style="font-size: 0.72rem;">Minimal 6 karakter.</small>
                                                    </div>

                                                    {{-- Opsi Peran & Status HANYA BISA DIUBAH OLEH OWNER --}}
                                                    @if(Auth::user()->isOwner())
                                                        <div class="row g-2">
                                                            <div class="col-6">
                                                                <label class="form-label small fw-semibold">Peran (Role)</label>
                                                                <select name="role" class="form-select form-select-sm" required>
                                                                    <option value="kasir" {{ in_array($user->role, ['kasir', 'admin']) ? 'selected' : '' }}>Kasir</option>
                                                                    <option value="owner" {{ in_array($user->role, ['owner', 'pemilik_warung']) ? 'selected' : '' }}>Owner</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label small fw-semibold">Status Akun</label>
                                                                <select name="is_active" class="form-select form-select-sm" required>
                                                                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                                                                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif (Blokir)</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-sm text-white" style="background-color: #550000;">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2"></i>
                                    Belum ada data akun pengguna.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
{{-- KONDISI 1: JIKA YANG MENGEDIT ADALAH OWNER (Bisa atur Role & Status) --}}
                                                @if(Auth::user()->isOwner())
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold">Peran (Role)</label>
                                                            <select name="role" class="form-select form-select-sm" required>
                                                                <option value="kasir" {{ in_array($user->role, ['kasir', 'admin']) ? 'selected' : '' }}>Kasir</option>
                                                                <option value="owner" {{ in_array($user->role, ['owner', 'pemilik_warung']) ? 'selected' : '' }}>Owner</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold">Status Akun / Shift</label>
                                                            <select name="is_active" class="form-select form-select-sm" required>
                                                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif (Sedang Shift)</option>
                                                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif (Selesai Shift)</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                {{-- KONDISI 2: JIKA KASIR MENGEDIT AKUNNYA SENDIRI (Role terkunci, Status Shift terbuka) --}}
                                                @else
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Status Shift Kasir</label>
                                                        <select name="is_active" class="form-select form-select-sm" required>
                                                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif (Sedang Masuk Shift)</option>
                                                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif (Selesai Shift / Tutup)</option>
                                                        </select>
                                                        <small class="text-muted" style="font-size: 0.72rem;">Ubah ke "Nonaktif" jika Anda sudah selesai bertugas agar terpantau di dashboard Owner.</small>
                                                    </div>
                                                @endif
{{-- MODAL TAMBAH USER HANYA DIRUBAH JIKA OWNER --}}
@if(Auth::user()->isOwner())
    <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" style="color: #550000;">
                            <i class="bi bi-person-plus-fill me-1"></i>Tambah Akun Kasir Baru
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="Nama Karyawan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Email / Username Login</label>
                            <input type="email" name="email" class="form-control form-control-sm" placeholder="kasir@waroeng86.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Kata Sandi</label>
                            <input type="password" name="password" class="form-control form-control-sm" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small fw-semibold">Peran (Role)</label>
                                <select name="role" class="form-select form-select-sm" required>
                                    <option value="kasir" selected>Kasir</option>
                                    <option value="owner">Owner</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold">Status Akun</label>
                                <select name="is_active" class="form-select form-select-sm" required>
                                    <option value="1" selected>Aktif Langsung</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm text-white" style="background-color: #550000;">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
