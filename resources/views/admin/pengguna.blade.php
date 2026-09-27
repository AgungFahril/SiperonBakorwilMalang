@extends('layouts.admin')

@section('title', 'Pengguna - Admin SIPERON')

@section('content')
    <div class="page-header-row">
        <div>
            <div class="page-title">Data Pengguna</div>
            <p class="page-subtitle">Kelola akun pengguna yang dapat mengakses sistem</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="filter-bar">
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">Semua <span class="tab-count">148</span></button>
            <button class="filter-tab" data-filter="admin">Admin <span class="tab-count">3</span></button>
            <button class="filter-tab" data-filter="operator">Operator <span class="tab-count">5</span></button>
            <button class="filter-tab" data-filter="user">Peminjam <span class="tab-count">140</span></button>
        </div>
        <div class="filter-actions">
            <div class="search-input">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                <input type="text" placeholder="Cari nama atau email...">
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Instansi</th>
                        <th>Terdaftar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>
                            <div class="user-cell">
                                <img src="https://ui-avatars.com/api/?name=Admin+Bakorwil&background=0284c7&color=fff&size=36" alt="" class="user-cell-avatar">
                                <div class="cell-main">Admin Bakorwil</div>
                            </div>
                        </td>
                        <td>admin@bakorwil3.go.id</td>
                        <td><span class="role-badge role-admin">Admin</span></td>
                        <td>Bakorwil III Malang</td>
                        <td>01 Jan 2025</td>
                        <td><span class="status-badge status-approved">Aktif</span></td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>
                            <div class="user-cell">
                                <img src="https://ui-avatars.com/api/?name=Siti+Rahayu&background=00bcd4&color=fff&size=36" alt="" class="user-cell-avatar">
                                <div class="cell-main">Siti Rahayu</div>
                            </div>
                        </td>
                        <td>siti.rahayu@bakorwil3.go.id</td>
                        <td><span class="role-badge role-operator">Operator</span></td>
                        <td>Bakorwil III Malang</td>
                        <td>15 Mar 2025</td>
                        <td><span class="status-badge status-approved">Aktif</span></td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>
                            <div class="user-cell">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=f97316&color=fff&size=36" alt="" class="user-cell-avatar">
                                <div class="cell-main">Budi Santoso</div>
                            </div>
                        </td>
                        <td>budi.s@disdik.jatimprov.go.id</td>
                        <td><span class="role-badge role-user">Peminjam</span></td>
                        <td>Dinas Pendidikan Prov Jatim</td>
                        <td>10 Jun 2026</td>
                        <td><span class="status-badge status-approved">Aktif</span></td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>
                            <div class="user-cell">
                                <img src="https://ui-avatars.com/api/?name=Rina+Susanti&background=8b5cf6&color=fff&size=36" alt="" class="user-cell-avatar">
                                <div class="cell-main">Rina Susanti</div>
                            </div>
                        </td>
                        <td>rina.s@kominfo.malangkota.go.id</td>
                        <td><span class="role-badge role-user">Peminjam</span></td>
                        <td>Dinas Kominfo Malang</td>
                        <td>22 Jul 2026</td>
                        <td><span class="status-badge status-approved">Aktif</span></td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>
                            <div class="user-cell">
                                <img src="https://ui-avatars.com/api/?name=Agus+Widodo&background=10b981&color=fff&size=36" alt="" class="user-cell-avatar">
                                <div class="cell-main">Agus Widodo</div>
                            </div>
                        </td>
                        <td>agus.w@disparbudpora.jatimprov.go.id</td>
                        <td><span class="role-badge role-user">Peminjam</span></td>
                        <td>Dinas Pariwisata Jatim</td>
                        <td>05 Agu 2026</td>
                        <td><span class="status-badge status-pending">Nonaktif</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="table-footer">
            <div class="table-info">Menampilkan <strong>1 - 5</strong> dari <strong>148</strong> pengguna</div>
            <div class="pagination">
                <button class="page-btn" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">...</button>
                <button class="page-btn">30</button>
                <button class="page-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                </button>
            </div>
        </div>
    </div>
@endsection
