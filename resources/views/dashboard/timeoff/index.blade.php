@extends('layouts.app')
@section('title', 'Timeoff Settings')

@section('title-header', 'Timeoff Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Timeoff Settings</li>
@endsection

@section('action_btn')
    <a href="{{route('timeoff-settings.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary btnReport shadow-sm">Tambah Data</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Timeoff Settings</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Cuti</th>
                                    <th>Deskripsi Cuti</th>
                                    <th>Kode Cuti</th>
                                    <th>Durasi Cuti</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($timeoff as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->jenis_timeoff }}</td>
                                        <td>{{ $user->description_timeoff }}</td>
                                        <td class="text-uppercase">
                                            {{ $user->code_timeoff }}
                                        </td>
                                        <td>
                                            {{ $user->durasi_timeoff }} Hari
                                        </td>
                                        <td class="d-flex jutify-content-center">
                                            <a href="{{route('timeoff-settings.edit', $user->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('timeoff-settings.destroy', $user->id) }}" class="d-none" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="deleteForm('{{$user->id}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">
                                        {{ $timeoff->links() }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteForm(id){
            Swal.fire({
                title: 'Hapus data',
                text: "Anda akan menghapus data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${id}`).submit()
                }
            })
        }
    </script>
@endsection
