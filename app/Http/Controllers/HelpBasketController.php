<?php

namespace App\Http\Controllers;

use App\Basket\HelpBasket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

use App\Commune;

class HelpBasketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $helpbaskets = HelpBasket::search($request->input('search'))->orderByDesc('updated_at')->paginate(100);
        return view('help_basket.index', compact('helpbaskets'));
    }


    public function georeferencing()
    {
        //

        $data = array();

        $helpbaskets = HelpBasket::all();

        foreach ($helpbaskets as $key => $helpbasket) {
            if ($helpbasket->latitude != null and $helpbasket->longitude != null) {
                $data[$helpbasket->address . " " . $helpbasket->number . ", " . $helpbasket->commune][$helpbasket->identifier]['paciente'] = $helpbasket;
            }
        }



        return view('help_basket.georeferencing', compact('helpbaskets', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$communes = Commune::where('region_id', 1)->orderBy('name')->get();

        $communes = Commune::where('region_id',[env('REGION')])->orderBy('name')->get();
        //$communes = Commune::where('region_id',[config('app.REGION')])->orderBy('name')->get();
        return view('help_basket.create', compact('communes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $integrityrun = HelpBasket::whereNotNull('run')->where('run', $request->run)->exists();
        $integrityaddress = HelpBasket::where('address', $request->address)->where('number', $request->number)->where('department', $request->department)->exists();
        //dd($integrityrun);
        if ($integrityrun != null) {
            session()->flash('danger', 'A este RUN ya se le entrego canasta familiar. Vuelva a ingresar datos');
            return redirect()->route('help_basket.create');
        } else {
            if ($integrityaddress) {
                //dd($integrityaddress->address);
                session()->flash('danger', 'Ya fue entregado anteriormente a esta dirección');
                return redirect()->route('help_basket.create');
            } else {
                $helpbaket = new HelpBasket($request->All());
                $helpbaket->user_id = auth()->user()->id;

                if ($request->file('photoid')) {
                    $storage = $helpbaket->run;
                    $storage += $helpbaket->other_identification;
                    $storage = $storage . '_id';
                    $ext = $request->file('photoid')->extension();
                    $imageName = $storage . "." . $ext;
                    //genera la imagen 300 a 200
                    $image = Image::make($request->file('photoid'))->resize(300, 200);
                    Storage::disk('local')->put('help_baskets/' . $imageName, (string) $image->encode());
                    $helpbaket->photoid = 'help_baskets/' . $imageName;
                }


                if ($request->file('photo')) {
                    $storage = $helpbaket->run;
                    $storage += $helpbaket->other_identification;
                    // //$storage = $storage.'_id';
                    $ext = $request->file('photo')->extension();
                    $imageName = $storage . "." . $ext;
                    //genera la imagen 300 a 200
                    $image = Image::make($request->file('photo'))->resize(300, 200);
                    $location = Storage::disk('local')->put('help_baskets/' . $imageName, (string) $image->encode());
                    $helpbaket->photo = 'help_baskets/' . $imageName;
                }


                $helpbaket->save();
                session()->flash('success', 'Se recepcionó la canasta exitosamente');
                return redirect()->route('help_basket.index');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Basket\HelpBasket  $helpBasket
     * @return \Illuminate\Http\Response
     */
    public function show(HelpBasket $helpBasket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Basket\HelpBasket  $helpBasket
     * @return \Illuminate\Http\Response
     */
    public function edit(HelpBasket $helpBasket)
    {
        //
        //$communes = Commune::where('region_id', 1)->orderBy('name')->get();
        $communes = Commune::where('region_id', [env('REGION')])->orderBy('name')->get();
        return view('help_basket.edit', compact('helpBasket', 'communes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Basket\HelpBasket  $helpBasket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HelpBasket $helpBasket)
    {
        //
        //dd($request->file('photo'));
        $helpBasket->fill($request->all());
        $helpBasket->user_id = auth()->user()->id;

        if ($request->file('photo')) {
            $storage = $helpBasket->run;
            $storage += $helpBasket->other_identification;
            $ext = $request->file('photo')->extension();
            $imageName = $storage . "." . $ext;
            $image = Image::make($request->file('photo'))->resize(300, 200);
            Storage::disk('local')->put('help_baskets/' . $imageName, (string) $image->encode());
            $helpBasket->photo = 'help_baskets/' . $imageName;
            //$helpBasket->photo = $request->file('photo')->storeAs('help_baskets', $storage . '.' . $ext);

        }

        if ($request->file('photoid')) {
            $storage = $helpBasket->run;
            $storage += $helpBasket->other_identification;
            $storage = $storage . '_id';
            $ext = $request->file('photoid')->extension();
            //$helpBasket->photoid = $request->file('photoid')->storeAs('help_baskets', $storage . '.' . $ext);
            $imageName = $storage . "." . $ext;
            $image = Image::make($request->file('photoid'))->resize(300, 200);
            Storage::disk('local')->put('help_baskets/' . $imageName, (string) $image->encode());
            $helpBasket->photoid = 'help_baskets/' . $imageName;
        }

        $helpBasket->save();
        session()->flash('success', 'Se actualizo los datos exitosamente');
        return redirect()->route('help_basket.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Basket\HelpBasket  $helpBasket
     * @return \Illuminate\Http\Response
     */
    public function destroy(HelpBasket $helpBasket)
    {
        //
        $helpBasket->delete();
        session()->flash('success', 'Entrega de Canaste Eliminada Exitosamente');
        return redirect()->route('help_basket.index');
    }




    public function download($storage, $file)
    {
        return Storage::download($storage . '/' . $file);
    }

    public function excel()
    {
        $helpbaskets = HelpBasket::orderByDesc('updated_at')->get();;
        return view('help_basket.excel', compact('helpbaskets'));
    }
}
