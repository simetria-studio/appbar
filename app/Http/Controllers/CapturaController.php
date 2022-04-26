<?php

namespace App\Http\Controllers;

use App\Models\Mails;
use App\Mail\Captacao;
use App\Models\Captura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CapturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save = Captura::create([
            'name' => $request['name'],
            'whatsapp' => $request['whatsapp'],
            'email' => $request['email'],
      
        ]);

        $mails = new Mails();
        $mails['name'] = $request->name;

        Mail::to($request->email)->send(new Captacao($mails));

        return redirect()->route('thanks');
    }

    public function thanks()
    {
        return view('front.thanks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
