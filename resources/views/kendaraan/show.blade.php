@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Show kendaraan</h2>
        <div class="lead">
            
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
                Tarif: @currency($kendaraan->tarif)/hari
            </div>
        </div>

    </div>
    @auth
        @role('admin')
        <div class="mt-4">
            <a href="{{ route('kendaraan.edit', $kendaraan->id) }}" class="btn btn-info">Edit</a>
            <a href="{{ route('kendaraan.index') }}" class="btn btn-default">Back</a>
        </div>
        @endrole
    @endauth
@endsection
