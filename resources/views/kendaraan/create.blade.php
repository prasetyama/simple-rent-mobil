@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Tambah kendaraan</h2>
        <div class="lead">
            Tambah kendaraan.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('kendaraan.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="merk" class="form-label">Merk</label>
                    <input value="{{ old('merk') }}" 
                        type="text" 
                        class="form-control" 
                        name="merk" 
                        placeholder="Merk" required>

                    @if ($errors->has('merk'))
                        <span class="text-danger text-left">{{ $errors->first('merk') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="model" class="form-label">Model</label>
                    <input value="{{ old('model') }}" 
                        type="text" 
                        class="form-control" 
                        name="model" 
                        placeholder="Model" required>

                    @if ($errors->has('model'))
                        <span class="text-danger text-left">{{ $errors->first('model') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="plat_number" class="form-label">Plat Nomor</label>
                    <input value="{{ old('plat_number') }}" 
                        type="text" 
                        class="form-control" 
                        name="plat_number" 
                        placeholder="Plat Nomor" required>

                    @if ($errors->has('plat_number'))
                        <span class="text-danger text-left">{{ $errors->first('plat_number') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="tarif" class="form-label">Tarif</label>
                    <input value="{{ old('tarif') }}" 
                        type="text" 
                        class="form-control" 
                        name="tarif" 
                        placeholder="Tarif" required>

                    @if ($errors->has('tarif'))
                        <span class="text-danger text-left">{{ $errors->first('tarif') }}</span>
                    @endif
                </div>
                

                <button type="submit" class="btn btn-primary">Save role</button>
                <a href="{{ route('kendaraan.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection