<div class="panel shadow-sm">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-uppercase">Daftar pengguna dengan hak akses <b>{{ $data->name }}</b> :</h5>
            </div>
            <table id="user-datatable" class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th class="w-0">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                </tr>
                </thead>
                <tbody>
                @forelse($data->users as $no => $user)
                    <tr>
                        <td>{{ $no+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->level->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .modal-lg {
        max-width: 1000px !important;
    }
</style>
<script>
    $('.submit-data').hide();
    $('#user-datatable').DataTable();
    $('.modal-title').html('<i class="fa fa-eye"></i> Detail Data {{ $page->title }}');
</script>
