<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        //
        $categorias['categorias']=Categoria::paginate(15);
        $series['series']=Serie::paginate(15);
        return view('serie.index',$series,$categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categorias['categorias']=Categoria::paginate(15);
        
        return view('serie.create',$categorias);
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

        $validacion=[
            'Nombre'=>'required|string|max:100',
            'Categoria'=>'required|string|max: 100',
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido',
            
        ];

        $series = new Serie();
        $series->nombre = $request->Nombre;
        $series->categorias_id = $request->Categoria;
        $series->save();
        //return response()->json($datosSerie);
        return redirect('serie')->with('mensaje','La serie ha sido agregada');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function show(Serie $serie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $categorias=Categoria::all();
        $serie=Serie::find($id);
        return view('serie.edit')
        ->with('serie',$serie)
        ->with('categorias',$categorias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validacion=[
            'Nombre'=>'required|string|max:100',
            'Categoria'=>'required|string|max: 100',
            
        ];

        $mensaje=[
            'required'=>'El :attribute es requerido',
            
        ];
        if($request->hasFile('Imagen')){
            $validacion=['Imagen'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensaje=['Imagen.required' =>'Falta la imagen'];
        }

        $serie=Serie::find($id);
        $serie->nombre = $request->Nombre;
        $serie->categorias_id = $request->Categoria;
        $serie->update();

        return redirect('serie')->with('mensaje','Los datos han sido modificados');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $serie=Serie::findOrFail($id);
        if(Storage::delete('public/'.$serie->imagen)){
            Serie::destroy($id);
        };

    
        return redirect('serie')->with('mensaje','La serie ha sido eliminada');
    }

    public function imagen($id){
        return view('serie.upload')
        ->with('id',$id);
    }

    public function upload(Request $request, $id){
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'image.required' => 'Seleccione un archivo.',
            'image.image' => 'Formato no valido.',
            'image.mimes' => 'Formato no valido.',
            'image.max' => 'Peso excede el maximo permitido (Max: 2Mb).'
        ]);

        $imageName = $id.'.jpg';
        $request->image->move(('img/series'), $imageName);
        return redirect('serie')->with('Imagen cargada');
    }
}
