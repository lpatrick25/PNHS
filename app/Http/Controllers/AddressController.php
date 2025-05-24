<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brgy;
use App\Models\Municipality;
use App\Models\Province;

class AddressController extends Controller
{

    public function getBrgys($municipality_code)
	{
		$brgyList = Brgy::where('municipality_code', $municipality_code)->get();
		return response()->json($brgyList);
	}

    public function getZipCode($municipality_code)
	{
		$zipCode = Municipality::where('municipality_code', $municipality_code)->first();
		return response()->json($zipCode);
	}

    public function getMunicipalities($province_code)
	{
		$municipalityList = Municipality::where('province_code', $province_code)->get();
		return response()->json($municipalityList);
	}

    public function getProvinces($region_code)
	{
		$provinceList = Province::where('region_code', $region_code)->get();
		return response()->json($provinceList);
	}
}
