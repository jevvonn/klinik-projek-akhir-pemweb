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

    .form-card {
      width: 100%;
      max-width: 900px;
      background: var(--card);
      padding: 28px;
      border-radius: var(--radius);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid #ddd;
    }

    .two-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      margin-bottom: 20px;
    }

    .field {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    label {
      font-size: 14px;
      font-weight: 600;
      color: #555;
    }

    input,
    select,
    textarea {
      padding: 14px;
      border-radius: 10px;
      border: 2px solid var(--border);
      font-size: 15px;
      outline: none;
      transition: 0.2s;
    }

    input:focus,
    select:focus,
    textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.25);
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    .actions {
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      margin-top: 20px;
    }

    .btn-reset,
    .btn-submit {
      padding: 12px 22px;
      border-radius: 10px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: 0.2s;
    }

    .btn-reset {
      background: white;
      border: 2px solid #999;
      color: #555;
    }

    .btn-reset:hover {
      background: #999;
      color: white;
    }

    .btn-submit {
      background: var(--primary);
      color: white;
    }

    .btn-submit:hover {
      background: var(--primary-hover);
    }

    @media (max-width: 700px) {
      .two-col {
        grid-template-columns: 1fr;
      }

      .sidebar {
        width: 190px;
      }
    }
  </style>
@endsection

@section('content')
  <!-- MAIN CONTENT -->
  <main class="main">
    <form class="form-card" id="formPasien" method="POST" action="{{ route('klinik.request.store') }}">
      @csrf
      <div class="two-col">
        <div class="field">
          <label>Nama Lengkap</label>
          <input name="nama" type="text" required placeholder="contoh: Siti Aminah" />
          @error('nama')
            <small style="color:red">{{ $message }}</small>
          @enderror
        </div>

        <div class="field">
          <label>No. HP</label>
          <input name="no_hp" type="text" placeholder="08xxxxxxxx" />
          @error('no_hp')
            <small style="color:red">{{ $message }}</small>
          @enderror
        </div>
      </div>

      <div class="two-col">
        <div class="field">
          <label>Umur</label>
          <input name="umur" type="number" min="0" />
          @error('umur')
            <small style="color:red">{{ $message }}</small>
          @enderror
        </div>

        <div class="field">
          <label>Jenis Kelamin</label>
          <select name="jenis_kelamin">
            <option selected disabled>Pilih</option>
            <option value="Laki-Laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
          @error('jeni')
            <small style="color:red">{{ $message }}</small>
          @enderror
        </div>
      </div>

      <div class="field" style="margin-bottom: 20px">
        <label>Alamat</label>
        <input name="alamat" type="text" />
        @error('alamat')
          <small style="color:red">{{ $message }}</small>
        @enderror
      </div>

      <div class="two-col">
        <div class="field">
          <label>Diagnosa</label>
          <input name="diagnosa" type="text" />
          @error('diagnosa')
            <small style="color:red">{{ $message }}</small>
          @enderror
        </div>

        <div class="field">
          <label>Dokter</label>
          <input name="dokter" type="text" />
          @error('dokter')
            <small style="color:red">{{ $message }}</small>
          @enderror
        </div>
      </div>

      <div class="field">
        <label>Resep / Instruksi Obat</label>
        <textarea name="resep_obat" placeholder="Masukkan resep di sini..."></textarea>
        @error('resep_obat')
          <small style="color:red">{{ $message }}</small>
        @enderror
      </div>

      <div class="actions">
        <button type="button" class="btn-reset" onclick="resetForm()">
          Reset
        </button>
        <button class="btn-submit">Kirim Request Resep</button>
      </div>
    </form>
  </main>

  <script>
    const form = document.getElementById("formPasien");

    function resetForm() {
      if (confirm("Reset form?")) form.reset();
    }
  </script>
@endsection
