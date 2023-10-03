@extends('layouts.app-master')

@section('content')

    @auth
        @role('admin')
            <h1 class="mb-3">Pesanan</h1>
        @else
            <h1 class="mb-3">Pesanan Saya</h1>
        @endif
    @endauth

    <div class="bg-light p-4 rounded">
        <div class="row">
            <div class="col-md-8">
                <h2>Daftar Kendaraan</h2>
            </div>
            <div class="col-md-4">
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action="/kendaraan/my-booking" method="GET">
                <input type="search" name="search" class="form-control form-control" placeholder="Search..." aria-label="Search" value="{{ request()->get('search') }}">
            </form>
            </div>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Merk</th>
             <th>Model</th>
             <th>Plat Nomor</th>
             <th>Total Biaya</th>
             <th>Tanggal Mulai Peminjaman</th>
             <th>Tanggal Pengembalian Peminjaman</th>
             @role('admin')
                <th>Peminjam</th>
             @endrole
             <th>Sudah Dikembalikan</th>
          </tr>
            @foreach ($booking as $key => $item)
            <tr>
                <td>{{ $key +1 }}</td>
                <td>{{ $item->kendaraan->merk }}</td>
                <td>{{ $item->kendaraan->model }}</td>
                <td>{{ $item->kendaraan->plat_number }}</td>
                <td>@currency($item->total_biaya)</td>
                <td>{{ $item->start_date }}</td>
                <td>{{ $item->end_date }}</td>
                @role('admin')
                    <td>{{$item->user->name}}</td>
                @endrole
                <td>
                    @if ($item->is_return)
                        <span class="btn btn-primary">Ya</span>
                    @else
                        @auth
                            @role('admin')
                            {!! Form::open(['method' => 'PATCH','route' => ['kendaraan.return', $item->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Return', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                            @else 
                                <span class="btn btn-danger">Belum</span>
                            @endif
                        @endauth
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $booking->links() !!}
        </div>

    </div>
@endsection
