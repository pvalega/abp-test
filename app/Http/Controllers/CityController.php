<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Mail\SendEmail;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: ' .env('API_KEY_CITY')
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            $error = curl_error($curl);
            $errorNo = curl_errno($curl);
            // Manejar el error, por ejemplo:
            echo "Error al hacer la solicitud cURL: $error (Error code: $errorNo)";

        } else {
            $countries = json_decode($response);
            return view('city',compact('countries'));

        }

    }

    public function ciudades()
    {
            $cities = City::where('user_id',Auth::user()->id)->get();
            return view('my-city',compact('cities'));

    }


    public function getState($countryId){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$countryId.'/states',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: ' .env('API_KEY_CITY')
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            $error = curl_error($curl);
            $errorNo = curl_errno($curl);
            // Manejar el error, por ejemplo:
            echo "Error al hacer la solicitud cURL: $error (Error code: $errorNo)";

        } else {
            return json_decode($response);
        }

    }


    public function getCity($countryId,$stateId){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$countryId.'/states/'.$stateId.'/cities',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                'X-CSCAPI-KEY: ' .env('API_KEY_CITY')
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            $error = curl_error($curl);
            $errorNo = curl_errno($curl);
            // Manejar el error, por ejemplo:
            echo "Error al hacer la solicitud cURL: $error (Error code: $errorNo)";

        } else {
            return json_decode($response);
        }

    }

    public function infoCity($city,$country){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.api-ninjas.com/v1/city?name='.$city.'&country='.$country,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                'X-Api-Key: ' .env('API_KEY_NINJA')
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            $error = curl_error($curl);
            $errorNo = curl_errno($curl);
            // Manejar el error, por ejemplo:
            echo "Error al hacer la solicitud cURL: $error (Error code: $errorNo)";

        } else {
            return $response;
        }

    }


    public function store(Request $request){

        $request->validate([
            'city' => 'required|string'
        ]);

        $count = City::where('user_id',Auth::user()->id)->count();

        if($count<=4) {

            DB::beginTransaction();

            $city = City::create([
                'name' => strtoupper($request->city),
                'data' => strtoupper($request->miTextarea),
                'user_id' => Auth::user()->id,
            ]);

            if ($city) {
                DB::commit();
                $data = ['message' => 'Ciudad '. $city->name .' Creada'];
                Mail::to(Auth::user()->email)->send(new SendEmail($data));
                return response()->json(['res' => $city]);
            } else {
                DB::rollbackTransaction();
                return response()->json(['err' => 'Ciudad no pudo ser registrada']);
            }
        }else{
            return response()->json(['err' => 'Ha superado el limite de ciudades a guardar!']);
        }
    }

    public function destroy($id){

        $city= City::where('id',$id)->first();
        try {
            if ($city->delete()) {
                $data = ['message' => 'Ciudad '.$city->name .' Eliminada'];
                Mail::to(Auth::user()->email)->send(new SendEmail($data));
                return response()->json(['res' => 'Elimineado']);
            } else {
                return response()->json(['err' => 'Ciudad no se ha podido eliminar']);
            }
        } catch (Exception $e) {
            return response()->json(['err' => $e]);
        }
    }

}
