@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Sewa kendaraan</h2>
        <div class="lead">
            Sewa kendaraan.
        </div>

        <div class="container mt-4">

            <div>
                Merk: {{ $kendaraan->merk }}
            </div>
            <div>
                Model: {{ $kendaraan->model }}
            </div>
            <div>
                Plat Nomor: {{ $kendaraan->plat_number }}
            </div>
            <div>
                Tarif: @currency($kendaraan->tarif) /Hari
            </div><br>

            <form method="POST" action="{{ route('kendaraan.bookProcess', $kendaraan->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="start_book" class="form-label">Tanggal Menyewa</label>
                    <input value="{{ old('start_book') }}" 
                        id="start-datepicker"
                        type="text" 
                        class="form-control date" 
                        name="start_date" 
                        placeholder="Start Book" required>

                    @if ($errors->has('start_date'))
                        <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="end_book" class="form-label">Tanggal Selesai</label>
                    <input value="{{ old('end_book') }}" 
                        id="end-datepicker"
                        type="text" 
                        class="form-control date"  
                        name="end_date" 
                        placeholder="Tanggal Selewai" required>

                    @if ($errors->has('end_date'))
                        <span class="text-danger text-left">{{ $errors->first('end_date') }}</span>
                    @endif
                </div>
                

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('kendaraan.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection