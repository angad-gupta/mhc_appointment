<?php
/**
 * Created by PhpStorm.
 * User: rifat
 * Date: 3/7/19
 * Time: 4:30 PM
 */

namespace App\Traits;


use App\Models\Drug;
use Illuminate\Http\Request;

trait DrugTrait
{
    /**
     * Save drug if not exist
     *
     * @param $drug_name
     * @return mixed
     */
    public function saveDrugIfNotExist($drug_name)
    {
        if (trim($drug_name) != '') {
            $drug = Drug::where('trade_name', trim($drug_name))->first();
            if (!is_object($drug)) {
                $drug = new Drug();
                $drug->trade_name = $drug_name;
                $drug->generic_name = str_random(25);
                $drug->department_id = auth()->user()->doctor->department_id;
                $drug->save();
            }
            return $drug_name;
        }
    }

    /**
     * Get drug by department
     */
    public function getDrugByDepartment()
    {
        $drug = Drug::where('department_id', 0);

        if (auth()->user()->role == 2) {

        }
    }

    public function filterDrug(Request $request)
    {

    }
}