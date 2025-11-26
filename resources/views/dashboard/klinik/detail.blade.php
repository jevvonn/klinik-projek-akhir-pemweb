@extends('dashboard.klinik.template')

@section('css')
  <style>
    :root {
      --bg: #a2d3e0;
      --sidebar: #ffffff;
      --sidebar-border: #d0d4d8;
      --primary: #4a90e2;
      --primary-hover: #357abd;
      --border: #c8c8c8;
      --card: #ffffff;
      --radius: 14px;
      font-family: Inter, system-ui, sans-serif;
    }

    .main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px;
    }

    .detail-card {
      width: 100%;
      max-width: 900px;
      background: var(--card);
      padding: 28px;
      border-radius: var(--radius);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid #ddd;
    }

    .detail-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      padding-bottom: 16px;
      border-bottom: 2px solid #e5e5e5;
    }

    .detail-header h1 {
      font-size: 24px;
      font-weight: 700;
      color: #333;
      margin: 0;
    }

    .status-badge {
      padding: 8px 16px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
    }

    /* .status-pending {
        background: #fff3cd;
        color: #856404;
      }

      .status-processed {
        background: #d4edda;
        color: #155724;
      } */

    .status-rejected {
      background: #f8d7da;
      color: #721c24;
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

    .two-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }

    .detail-field {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .detail-label {
      font-size: 13px;
      font-weight: 600;
      color: #777;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .detail-value {
      font-size: 16px;
      color: #333;
      padding: 12px;
      background: #f8f9fa;
      border-radius: 8px;
      border: 1px solid #e5e5e5;
    }

    .detail-value.large {
      min-height: 120px;
      white-space: pre-wrap;
    }

    .actions {
      display: flex;
      justify-content: flex-start;
      gap: 12px;
      margin-top: 24px;
      padding-top: 20px;
      border-top: 2px solid #e5e5e5;
    }

    button,
    .btn {
      padding: 12px 22px;
      border-radius: 10px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: 0.2s;
      text-decoration: none;
      display: inline-block;
    }

    .btn-back {
      background: white;
      border: 2px solid #999;
      color: #555;
    }

    .btn-back:hover {
      background: #999;
      color: white;
    }

    .btn-edit {
      background: #ffc107;
      color: #333;
    }

    .btn-edit:hover {
      background: #e0a800;
    }

    .btn-delete {
      background: #dc3545;
      color: white;
    }

    .btn-delete:hover {
      background: #c82333;
    }

    .btn-approve {
      background: #28a745;
      color: white;
    }

    .btn-approve:hover {
      background: #218838;
    }

    @media (max-width: 700px) {
      .two-col {
        grid-template-columns: 1fr;
      }

      .detail-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
      }

      .actions {
        flex-wrap: wrap;
      }
    }
  </style>
@endsection

@section('content')
  <main class="main">
    <div class="detail-card">
      <div class="detail-header">
        <h1>Detail Resep Pasien</h1>
        <span class="status-badge status-{{ $data->status }}">{{ $data->status }}</span>
      </div>

      <div class="two-col">
        <div class="detail-field">
          <span class="detail-label">Nama Lengkap</span>
          <div class="detail-value">{{ $data->nama }}</div>
        </div>

        <div class="detail-field">
          <span class="detail-label">No. HP</span>
          <div class="detail-value">{{ $data->no_hp }}</div>
        </div>
      </div>

      <div class="two-col">
        <div class="detail-field">
          <span class="detail-label">Umur</span>
          <div class="detail-value">{{ $data->umur }} tahun</div>
        </div>

        <div class="detail-field">
          <span class="detail-label">Jenis Kelamin</span>
          <div class="detail-value">{{ $data->jenis_kelamin }}</div>
        </div>
      </div>

      <div class="detail-field" style="margin-bottom: 20px">
        <span class="detail-label">Alamat</span>
        <div class="detail-value">{{ $data->alamat }}</div>
      </div>

      <div class="two-col">
        <div class="detail-field">
          <span class="detail-label">Diagnosa</span>
          <div class="detail-value">{{ $data->diagnosa }}</div>
        </div>

        <div class="detail-field">
          <span class="detail-label">Dokter</span>
          <div class="detail-value">{{ $data->dokter }}</div>
        </div>
      </div>

      <div class="detail-field">
        <span class="detail-label">Resep / Instruksi Obat</span>
        <div class="detail-value large">
          {{ $data->resep_obat }}
        </div>
      </div>

      {{-- <div class="actions">
        <a href="{{ route('klinik.request.index') }}" class="btn btn-back">
          Kembali
        </a>
        <a href="{{ route('klinik.request.edit', $data->id ?? 1) }}" class="btn btn-edit">
          Edit
        </a>
        <button class="btn btn-approve" onclick="approveRequest()">
          Setujui
        </button>
        <button class="btn btn-delete" onclick="deleteRequest()">
          Hapus
        </button>
      </div> --}}
    </div>
  </main>
@endsection
