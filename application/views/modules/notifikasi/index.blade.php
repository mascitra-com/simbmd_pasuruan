@layout('commons/index')
@section('title')Notifikasi@end

@section('breadcrump')
    <li class="breadcrumb-item"><a href="{{site_url()}}">Beranda</a></li>
    <li class="breadcrumb-item active">Notifikasi</li>
@end

@section('content')
    <div class="card">
        <div class="card-header form-inline">
            <div class="btn-group">
                <button class="btn btn-primary btn-refresh"><i class="fa fa-refresh mr-2"></i>Segarkan</button>
            </div>
        </div>
        <div class="card-body table-responsive px-0 py-0">
            <table class="table table-hover table-bordered clickable-row">
                <thead>
                <thead>
                <tr>
                    <th class="text-center" width="5%">No. </th>
                    <th class="text-nowrap" width="20%">Nama</th>
                    <th class="text-center">Deskripsi</th>
                    <th class="text-center" width="10%">Tipe</th>
                    <th class="text-center" width="5%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @if(empty($notifikasi))
                    <tr><td colspan="10" class="text-center">Tidak ada data</td></tr>
                @else
                    @foreach($notifikasi AS $notif)
                        <tr class="small">
                            <td class="text-center"><i class="fa fa-circle {{ $notif->is_read ? 'text-success' : 'text-warning' }}" style="line-height: 20px"></i></td>
                            <td>{{ $notif->title }}</td>
                            <td>{{ $notif->description }}</td>
                            <td>{{ notif($notif->type) }}</td>
                            <td class="text-center"><a href="{{ site_url('persetujuan/'.$notif->link) }}" class="btn btn-sm btn-primary"><i class="fa fa-bell"></i></a></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{!empty($pagination) ? $pagination : ''}}</div>
    </div>
    @end

@section('style')
    <style>
        .text-sm {font-size: smaller;}
    </style>
@end