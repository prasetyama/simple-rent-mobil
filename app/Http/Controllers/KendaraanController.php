<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Sewa;
use Spatie\Permission\Models\Role;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kendaraan = Kendaraan::latest()->paginate(10);

        $search = $request->search;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date && $end_date){
            $kendaraanNotAvail = Sewa::Select('kendaraan_id')
            ->whereBetween('sewa.start_date',[$start_date,$end_date])
            ->where('is_return', 0);

            $kendaraan = Kendaraan::whereNotIn('id', $kendaraanNotAvail)
            ->paginate(10);
        }

        if($search){

            $kendaraan = Kendaraan::where('merk','like',"%".$search."%")
            ->orWhere('model','like',"%".$search."%")
            ->orWhere('plat_number','like',"%".$search."%")
            ->paginate();
        }

        return view('kendaraan.index', compact('kendaraan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kendaraan::create(array_merge($request->only('merk', 'model', 'plat_number', 'tarif'),[
            'user_id' => auth()->id()
        ]));

        return redirect()->route('kendaraan.index')
            ->withSuccess(__('Kendaraan created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kendaraan  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Kendaraan $kendaraan)
    {
        return view('kendaraan.show', [
            'kendaraan' => $kendaraan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kendaraan  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraan.edit', [
            'kendaraan' => $kendaraan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kendaraan  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $kendaraan->update($request->only('merk', 'model', 'plat_number', 'tarif'));

        return redirect()->route('kendaraan.index')
            ->withSuccess(__('Kendaraan updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kendaraan  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')
            ->withSuccess(__('Kendaraan deleted successfully.'));
    }

    /**
     * Show the form for book the specified resource.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function book(Kendaraan $kendaraan)
    {
        $profile = Profile::Where('user_id', '=', auth()->id())->first();
        return view('kendaraan.book', [
            'kendaraan' => $kendaraan,
            'profile' => $profile
        ]);
    }

    public function bookProcess(Request $request, Kendaraan $kendaraan)
    {

        $start_book =  \Carbon\Carbon::createFromFormat('Y-m-d',$request->start_date);
        $end_book =  \Carbon\Carbon::createFromFormat('Y-m-d',$request->end_date);

        $day = $start_book->diffInDays($end_book);

        $matchThese = ['user_id' => auth()->id()];
        Profile::updateOrCreate($matchThese,['address' => $request->address, 'phone_number' => $request->phone_number, 'sim_number' => $request->sim_number]);

        Sewa::create(array_merge($request->only('start_date', 'end_date'),[
            'user_id' => auth()->id(),
            'kendaraan_id' => $kendaraan->id,
            'total_biaya' => $day * $kendaraan->tarif,
            'is_return' => false
        ]));

        return redirect()->route('kendaraan.index')
            ->withSuccess(__('Booking created successfully.'));
    }

    /**
     * Display a listing of the my booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function myBooking(Request $request)
    {
        if (auth()->user()->hasRole('admin')){
            $booking = Sewa::latest()->paginate(10);
        } else {
            $booking = Sewa::where('user_id', '=', auth()->id())->paginate(10);
        }

        $search = $request->search;

        if($search){

            $booking = Sewa::join('kendaraan', 'kendaraan.id', '=', 'sewa.kendaraan_id')
            ->where('kendaraan.merk','like',"%".$search."%")
            ->orWhere('kendaraan.model','like',"%".$search."%")
            ->orWhere('kendaraan.plat_number','like',"%".$search."%")
            ->paginate(10);
        }

        return view('kendaraan.my-booking', compact('booking'));
    }

    public function return($booking)
    {
        $now = \Carbon\Carbon::now();
        $return = Sewa::where('id', $booking)
                    ->update(['is_return' => 1, 'return_date' => $now]);

        return redirect()->route('kendaraan.myBooking')
            ->withSuccess(__('Kendaraan Telah Dikembalikan.'));
    }
}
