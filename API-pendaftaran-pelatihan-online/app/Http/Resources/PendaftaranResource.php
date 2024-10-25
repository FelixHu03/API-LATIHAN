<?php

namespace App\Http\Resources;

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
        return [
            'success' => true,
            'data' => [
                'id' => $this->id,
                'nama' => $this->nama,
                'email' => $this->email,
                'nomor_telepon' => $this->nomor_telepon,
                'tingkat_sekolah' => $this->tingkat_sekolah
            ]
        ];
    }
}
