<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\ServiceTransformer;
use App\Service;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::with(['getUser', 'tire', 'vehicle'])->paginate();
        if ($service) {
            $service = app('fractal')->collection($service, new ServiceTransformer())->getArray();
            return response()->json([
                'success' => true,
                'message' => 'Get Data Success',
                'data' => $service
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Get Data failed',
                'data' => ""
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->input('lepasban')) {
            $this->validate(
                $request,
                [
                    'alasanlepas' => 'required'
                ],
                [
                    'alasanlepas.required' => "Harus Pilih salah satu alasan lepas ban"
                ]
            );
        } else {
            $this->validate($request, [
                'tekanan_angin' => 'required',
                'tebal_tapak' => 'required',
                'posisi' => 'required|int',
                'jarakkm' => 'required|int',
            ]);
        }

        $service = new Service();
        $service->tire_id = $request->input("tire_id");
        $service->user = $request->input("user");
        $service->kendaraan = $request->input("kendaraan");
        $service->tekanan_angin = ($request->input("tekanan_angin")) ? $request->input("tekanan_angin") : 0;
        $service->tebal_tapak = ($request->input("tebal_tapak")) ? $request->input("tebal_tapak") : 0;
        $service->posisi = $request->input("posisi");
        $service->jarakkm = ($request->input("jarakkm")) ? $request->input("jarakkm") : 0;
        $service->catatan = $request->input("catatan");
        $service->kelainan = $request->input("kelainan");
        $service->lepasban = $request->input("lepasban");
        $service->alasanlepas = $request->input("alasanlepas");
        if ($service->save()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Simpan data sukses!',
                    'data' => $service
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Simpan data gagal!',
                    'data' => ""
                ],
                400
            );
        }
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
