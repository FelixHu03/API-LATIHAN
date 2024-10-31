<?php

namespace App\Http\Resources;

use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PendaftaranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return[
            'success' => true,
            'data' => [
                'id' => $this->id,
                'nama' => $this->nama,
                'email' => $this->email,
                'nomorTelepon' => $this->nomorTelepon,
                'tingkatSekolah' => $this->tingkatSekolah,
            ]
        ];
    }
}
