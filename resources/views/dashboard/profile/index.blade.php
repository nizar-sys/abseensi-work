@extends('layouts.app')
@section('title', 'Profile (' . $user->name . ')')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('profile') }}">Profile</a>
    </li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-4 order-xl-2">
            <div class="card card-profile">
                <img src="{{ asset('/assets/img/theme/img-1-1000x600.jpg') }}" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <form action="{{ route('change-ava') }}" id="form-upload" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="oldImage" id="oldImage" value="{{ $user->avatar }}">
                                <input type="file" class="d-none" name="image" id="uploadImage"><img
                                    style="cursor: pointer;" src="{{ asset('/uploads/images/' . $user->avatar) }}"
                                    class="rounded-circle" id="avaImage">
                            </form>

                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                </div>
                <div class="card-body pt-0 mt-xl-5">
                    <div class="text-center">
                        <h5 class="h3">
                            {{ $user->name }}
                        </h5>
                        <div class="h5 mt-2">
                            <i class="ni business_briefcase-24 mr-2"></i>{{ $user->role }}
                        </div>
                    </div>
                    <!-- Divider -->
                    <hr class="my-3">
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            @if ($user->user_log && $user->user_log == 'pending')

            <div class="alert alert-danger" role="alert">
                <strong>Warning!</strong> Status pengaduan anda masih <strong>menunggu konfirmasi</strong>, silahkan tunggu hingga status pengaduan anda berubah.
            </div>
            @elseif ($user->user_log && $user->user_log == 'rejected')
            <div class="alert alert-danger" role="alert">
                <strong>Warning!</strong> Status pengaduan anda <strong>ditolak</strong>, silahkan hubungi admin untuk informasi lebih lanjut.
                <br>
                Atau anda dapat mengirim ulang pengaduan anda dengan mengklik tombol dibawah.
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit profile </h3>
                        </div>
                        @if ($user->user_log && $user->user_log == 'approved')
                        <div class="col-4 text-right">
                            <button onclick="$('#form-update-prof').submit()" title="Save Changes"
                                class="btn btn-outline-primary btn-primary"><span class="fas fa-save"></span></button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-update-prof" action="{{ route('change-profile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Username</label>
                                        <input type="text" id="input-name"
                                            class="form-control @error('name')
                                        is-invalid
                                        @enderror"
                                            placeholder="Username" onkeyup="regSpace(this.value)" name="name"
                                            value="{{ $user->name }}" @disabled(!$user->user_log || $user->user_log != 'approved')>

                                        @error('name')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" id="input-email"
                                            class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                            placeholder="Email@example" value="{{ $user->email }}" name="email" @disabled(!$user->user_log || $user->user_log != 'approved')>
                                        @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="password">Katasandi Baru</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" placeholder="Katasandi Akun" name="password" @disabled(!$user->user_log || $user->user_log != 'approved')>

                                        @error('password')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="d-block invalid-feedback">Jangan isi kolom jika tidak ingin merubah
                                            katasandi akun.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />

                        <h6 class="heading-small text-muted mb-4">Personal information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="nik">NIK</label>
                                        <input type="number" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" placeholder="NIK pengguna"
                                            value="{{ old('nik', $user->personal?->nik) }}" name="nik" @disabled(!$user->user_log || $user->user_log != 'approved')>

                                        @error('nik')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group mb-3">
                                        <label for="address">Alamat</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Alamat pengguna"
                                            name="address" cols="30" rows="3" @disabled(!$user->user_log || $user->user_log != 'approved')>{{ old('address', $user->personal?->address) }}</textarea>

                                        @error('address')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-3">
                                        <label for="birth_place">Tempat lahir</label>
                                        <input type="text"
                                            class="form-control @error('birth_place') is-invalid @enderror"
                                            id="birth_place" placeholder="Tempat lahir pengguna"
                                            value="{{ old('birth_place', $user->personal?->birth_place) }}"
                                            name="birth_place" @disabled(!$user->user_log || $user->user_log != 'approved')>

                                        @error('birth_place')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group mb-3">
                                        <label for="birth_date">Tanggal lahir</label>
                                        <input type="date"
                                            class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                                            placeholder="Tanggal lahir pengguna"
                                            value="{{ old('birth_date', $user->personal?->birth_date) }}"
                                            name="birth_date" @disabled(!$user->user_log || $user->user_log != 'approved')>

                                        @error('birth_date')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="phone_number">Nomor telepon</label>
                                        <input type="number"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            id="phone_number" placeholder="Nomor telepon pengguna"
                                            value="{{ old('phone_number', $user->personal?->phone_number) }}"
                                            name="phone_number" @disabled(!$user->user_log || $user->user_log != 'approved')>

                                        @error('phone_number')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="gender">Jenis Kelamin</label>
                                        <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                            name="gender" @disabled(!$user->user_log || $user->user_log != 'approved')>
                                            @php
                                                $roles = ['male', 'female'];
                                            @endphp
                                            <option value="" selected>---Jenis Kelamin---</option>
                                            @foreach ($roles as $gender)
                                                <option value="{{ $gender }}"
                                                    @if (old('gender', $user->personal?->gender) == $gender) selected @endif>
                                                    {{ $gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</option>
                                            @endforeach
                                        </select>

                                        @error('gender')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="religion">Agama</label>
                                        <select class="form-control @error('religion') is-invalid @enderror"
                                            id="religion" name="religion" @disabled(!$user->user_log || $user->user_log != 'approved')>
                                            @php
                                                $roles = ['islam', 'kristen', 'buddha', 'katolik', 'konghucu'];
                                            @endphp
                                            <option value="" selected>---Agama---</option>
                                            @foreach ($roles as $religion)
                                                <option value="{{ $religion }}"
                                                    @if (old('religion', $user->personal?->religion) == $religion) selected @endif>
                                                    {{ ucfirst($religion) }}</option>
                                            @endforeach
                                        </select>

                                        @error('religion')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="marriage">Status Perkawinan</label>
                                        <input type="text"
                                            class="form-control @error('marriage') is-invalid @enderror" id="marriage"
                                            placeholder="Status Perkawinan pengguna"
                                            value="{{ old('marriage', $user->personal?->marriage) }}" name="marriage" @disabled(!$user->user_log || $user->user_log != 'approved')>

                                        @error('marriage')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />

                        <h6 class="heading-small text-muted mb-4">Employee information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="uuid">Kode Unik</label>
                                        <input type="text" class="form-control @error('uuid') is-invalid @enderror"
                                            id="uuid" placeholder="Kode Unik pengguna"
                                            value="{{ old('uuid', $user->employee?->uuid) }}" name="uuid" disabled>

                                        @error('uuid')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="employee_stats">Status Pekerja</label>
                                        <input type="text"
                                            class="form-control @error('employee_stats') is-invalid @enderror"
                                            id="employee_stats" placeholder="Status Pekerja pengguna"
                                            value="{{ old('employee_stats', $user->employee?->employee_stats) }}"
                                            name="employee_stats" @disabled(Auth::user()->role != 'admin' && !is_null($user->employee?->employee_stats))>

                                        @error('employee_stats')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="employee_tier">Posisi Pekerja</label>
                                        <input type="text"
                                            class="form-control @error('employee_tier') is-invalid @enderror"
                                            id="employee_tier" placeholder="Posisi Pekerja pengguna"
                                            value="{{ old('employee_tier', $user->employee?->employee_tier) }}"
                                            name="employee_tier" @disabled(Auth::user()->role != 'admin' && !is_null($user->employee?->employee_tier))>

                                        @error('employee_tier')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="institution">Tempat Pekerja</label>
                                        <input type="text"
                                            class="form-control @error('institution') is-invalid @enderror"
                                            id="institution" placeholder="Tempat Pekerja pengguna"
                                            value="{{ old('institution', $user->employee?->institution) }}"
                                            name="institution" @disabled(Auth::user()->role != 'admin' && !is_null($user->employee?->institution))>

                                        @error('institution')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="join_date">Tanggal Bergabung</label>
                                        <input type="date"
                                            class="form-control @error('join_date') is-invalid @enderror"
                                            id="join_date" placeholder="Tanggal Bergabung pengguna"
                                            value="{{ old('join_date', $user->employee?->join_date) }}"
                                            name="join_date" @disabled(Auth::user()->role != 'admin' && !is_null($user->employee?->join_date))>

                                        @error('join_date')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="length_of_work">Lama Bekerja</label>
                                        <input type="text"
                                            class="form-control @error('length_of_work') is-invalid @enderror"
                                            id="length_of_work" placeholder="Lama Bekerja pengguna"
                                            value="{{ old('length_of_work', $user->employee?->length_of_work) }}"
                                            name="length_of_work" @disabled(true)>

                                        @error('length_of_work')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                    </form>

                    @if (!$user->user_log || $user->user_log == 'rejected')

                    <form id="submission-form" action="{{ route('user-logs.store') }}" class="d-none" method="post">
                        @csrf
                    </form>
                    <button onclick="$('#submission-form').submit()" class="btn w-100 btn-warning">Ajukan permohonan edit data</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $('#avaImage').on('click', function() {
            event.preventDefault();

            $('input[name="image"]').click()
        })

        function bacaGambar(input) {
            try {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#avaImage').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);

                    Swal.fire({
                        title: 'Lanjutkan pasang foto profile?',
                        text: "Jadikan gambar sebagai foto profile",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya!',
                        cancelButtonText: 'Batalkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form-upload').submit()
                        } else {
                            $('#avaImage').attr('src', '/uploads/images/' + $('input[name="oldImage"]').val());
                        }
                    })
                }
            } catch (error) {

                Snackbar.show({
                    text: 'Error ' + error,
                    duration: 4000,
                });
                window.location.reload()
            }
        }

        $('input[name="image"]').change(function() {
            bacaGambar(this);
        });
    </script>
@endsection
