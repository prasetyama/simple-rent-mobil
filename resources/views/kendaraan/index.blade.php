@extends('layouts.app-master')

@section('content')
    
    <h1 class="mb-3">Sewa</h1>

    <div class="bg-light p-4 rounded">
        <div class="row" style="margin-bottom: 50px">
            <div class="col-md-8">
                <h2>Cek Ketersiadaan</h2>
                <form method="GET" action="/kendaraan">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="start_book" class="form-label">Tanggal Pinjam</label>
                            <input value="{{ request()->get('start_date') }}" 
                                id="start-datepicker"
                                type="text" 
                                class="form-control date" 
                                name="start_date" 
                                placeholder="Tanggal Pinjam" required>

                            @if ($errors->has('start_date'))
                                <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                            @endif
                        </div>
                        <div class="col-md-5">
                            <label for="end_book" class="form-label">Tanggal Selesai</label>
                            <input value="{{ request()->get('end_date') }}" 
                                id="end-datepicker"
                                type="text" 
                                class="form-control date"  
                                name="end_date" 
                                placeholder="Tanggal Selesai" required>

                            @if ($errors->has('end_date'))
                                <span class="text-danger text-left">{{ $errors->first('end_date') }}</span>
                            @endif
                        </div>
                        <div class="col-md-2" style="margin-top: 30px;">
                            <button type="submit" class="form-control btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action="/kendaraan" method="GET">
                <input type="search" name="search" class="form-control form-control" placeholder="Search..." aria-label="Search" value="{{ request()->get('search') }}">
            </form>
            </div>
        </div>
        @auth
            @role('admin')
            <div class="lead">
                Manage kendaraan.
                <a href="{{ route('kendaraan.create') }}" class="btn btn-primary btn-sm float-right">Tambah Kendaraan</a>
            </div>
            @endrole
        @endauth
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Merk</th>
             <th>Model</th>
             <th>Plat Nomor</th>
             <th>Tarif</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($kendaraan as $key => $item)
            <tr>
                <td>{{ $key +1 }}</td>
                <td>{{ $item->merk }}</td>
                <td>{{ $item->model }}</td>
                <td>{{ $item->plat_number }}</td>
                <td>@currency($item->tarif)/hari</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('kendaraan.show', $item->id) }}">Show</a>
                </td>
                @if (request()->get('start_date') && request()->get('end_date') )
                    <td>
                        <a class="btn btn-success btn-sm" href="{{ route('kendaraan.book', $item->id) }}">Book</a>
                    </td>
                @endif
                @auth
                    @role('admin')
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('kendaraan.edit', $item->id) }}">Edit</a>
                    </td>
                    <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['kendaraan.destroy', $item->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </td>
                    @endrole
                @endauth
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $kendaraan->links() !!}
        </div>

    </div>
@endsection
