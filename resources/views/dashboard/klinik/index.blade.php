@extends('dashboard.klinik.template')

@section('css')
  <style>
    .main-content {
      flex: 1;
      padding: 40px 60px;
    }

    h1 {
      font-size: 26px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 18px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    th,
    td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #2d8cff;
      color: white;
    }

    tr:hover {
      background-color: #f7faff;
    }

    .badge {
      padding: 7px 12px;
      border-radius: 6px;
      color: white;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
    }

    .status-pending {
      background-color: #f1c40f;
    }

    .status-processed {
      background-color: #3498db;
    }

    .status-completed {
      background-color: #27ae60;
    }

    .btn-logout {
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 10px 18px;
      cursor: pointer;
      border-radius: 6px;
      margin-top: 25px;
      transition: 0.2s;
    }

    .btn-logout:hover {
      background: #c0392b;
    }

    .btn-detail {
      padding: 8px 18px;
      border-radius: 10px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: 0.2s;
    }

    .btn-detail {
      background: white;
      border: 2px solid #999;
      color: #555;
    }
  </style>
@endsection



@section('content')
  <div class="main-content">

    <h1>Dashboard Monitoring Pasien</h1>
    <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong></p>

    <table>
      <thead>
        <tr>
          <th>Nama Pasien</th>
          <th>Jenis Kelamin</th>
          <th>Umur</th>
          <th>Status Obat</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        @forelse($requests as $req)
          <tr>
            <td><strong>{{ $req->nama }}</strong></td>
            <td>
              <strong>{{ $req->jenis_kelamin }}</strong>
            </td>
            <td>
              <strong>{{ $req->umur }}</strong>
            </td>
            <td>
              <span class="badge status-{{ $req->status }}">
                {{ $req->status }}
              </span>
            </td>
            <td>
              <a href="{{ route('dashboard-klinik-detail-pasien', $req->id) }}">
                <button class="btn-detail">Lihat Detail</button>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" style="text-align:center; padding:20px; color:#555;">
              Belum ada pasien saat ini.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  </div>
@endsection
