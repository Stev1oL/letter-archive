@extends('layouts.staff')

@section('title')
Tambah Surat
@endsection

@section('container')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file-text"></i></div>
                            Tambah Surat Masuk
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('surat-masuk-staff') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Kembali ke Semua Disposisi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <form action="{{ route('letter.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row gx-4">
                <div class="col-lg-9">
                    <div class="card mb-4">
                        <div class="card-header">Form Surat</div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="letter_type" class="col-sm-3 col-form-label">Jenis Surat</label>
                                <div class="col-sm-9">
                                    <select name="letter_type" class="form-control" required>
                                        <option value="Surat Masuk" {{ (old('letter_type') == 'Surat Masuk')? 'selected':''; }}>Surat Masuk</option>
                                    </select>
                                </div>
                                @error('letter_type')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="letter_no" class="col-sm-3 col-form-label">No. Surat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('letter_no') is-invalid @enderror" value="{{ old('letter_no') }}" name="letter_no" placeholder="Nomor Surat.." required>
                                </div>
                                @error('letter_no')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="letter_date" class="col-sm-3 col-form-label">Tanggal Surat</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('letter_date') is-invalid @enderror" value="{{ old('letter_date') }}" name="letter_date" required>
                                </div>
                                @error('letter_date')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="date_received" class="col-sm-3 col-form-label">Tanggal Diterima</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control @error('date_received') is-invalid @enderror" value="{{ old('date_received') }}" name="date_received" required>
                                </div>
                                @error('date_received')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="agenda_no" class="col-sm-3 col-form-label">No.Agenda</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('agenda_no') is-invalid @enderror" value="{{ old('agenda_no') }}" name="agenda_no" placeholder="No.Agenda.." required>
                                </div>
                                @error('agenda_no')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="regarding" class="col-sm-3 col-form-label">Perihal</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('regarding') is-invalid @enderror" value="{{ old('regarding') }}" name="regarding" placeholder="Perihal.." required>
                                </div>
                                @error('regarding')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="disposisi" class="col-sm-3 col-form-label">Tujuan Disposisi</label>
                                <div class="col-sm-9 row" style="float: right;">
                                    <div class="col-sm-4">
                                        <input type="checkbox" value="Wakil Rektor I" name="disposisi[]"> Wakil Rektor I <br>
                                        <input type="checkbox" value="Kepala Biro" name="disposisi[]"> Kepala Biro <br>
                                        <input type="checkbox" value="Kasubbag" name="disposisi[]"> Kasubbag <br>
                                        <input type="checkbox" value="Dekan Fakultas" name="disposisi[]"> Dekan Fakultas <br>
                                        <input type="checkbox" value="Koordinator Prodi" name="disposisi[]"> Koordinator Prodi <br>
                                        <input type="checkbox" value="Kepala Unit" name="disposisi[]"> Kepala Unit <br>
                                        <input type="checkbox" value="-" name="disposisi[]"> -
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="checkbox" value="Wakil Rektor II" name="disposisi[]"> Wakil Rektor II <br>
                                        <input type="checkbox" value="Kabag" name="disposisi[]"> Kabag <br>
                                        <input type="checkbox" value="Direktur" name="disposisi[]"> Direktur <br>
                                        <input type="checkbox" value="Ketua Jurusan" name="disposisi[]"> Ketua Jurusan <br>
                                        <input type="checkbox" value="Ketua Lembaga" name="disposisi[]"> Ketua Lembaga <br>
                                        <input type="checkbox" value="Kepala Lab" name="disposisi[]"> Kepala Lab <br>
                                    </div>
                                </div>
                                @error('disposisi')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3 row">
                                <label for="department_id" class="col-sm-3 col-form-label">Departemen</label>
                                <div class="col-sm-9">
                                    <select name="department_id" class="form-control" required>
                                        <option value="">Pilih Departemen...</option>
                                        @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ (old('department_id') == $department->id)? 'selected':''; }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department_id')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="sender_id" class="col-sm-3 col-form-label">Pengirim</label>
                                <div class="col-sm-9">
                                    <select name="sender_id" class="form-control" required>
                                        <option value="">Pilih Pengirim..</option>
                                        @foreach ($senders as $sender)
                                        <option value="{{ $sender->id }}" {{ (old('sender_id') == $sender->id)? 'selected':''; }}>{{ $sender->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('sender_id')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="letter_file" class="col-sm-3 col-form-label">File</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control @error('letter_file') is-invalid @enderror" value="{{ old('letter_file') }}" name="letter_file" required>
                                    <div id="letter_file" class="form-text">Ekstensi .pdf | <span style="color: blue;"> * Harus diisi</span></div>
                                </div>
                                @error('letter_file')
                                <div class="invalid-feedback">
                                    {{ $message; }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="letter_file" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@push('addon-style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@push('addon-script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(".selectx").select2({
        theme: "bootstrap-5"
    });
</script>
@endpush