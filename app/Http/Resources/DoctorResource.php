<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'doctor-slug' => $this->slug,
            'full_name' => $this->full_name,
            'links' => [
                'self' => route("api.doctors",$this->slug),
                'department' => route('api.department',$this->department->slug),
            ],
            'phone' => $this->phone,
            'photo' => asset($this->photo),
            'gender' => $this->sex,
            'info' => $this->info,
            'description' => $this->description,
            'is_featured' => $this->featured,
            'department' => $this->department->title,
            'experience_in_years' => $this->experience,
            'doctor_status' => $this->doctor_status,
            'video_consultation_fee' => $this->video_consultation_fee,
            'qualification' => $this->qualification,
            'normal_consultation_fee' => $this->normal_consultation_fee,
            'video_consultation' => $this->video_consultation,
            'services' => $this->services,
            'nmc_number' => $this->nmc_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'encrypted_id' => $this->encrypted_id,
         ];
    }
}
