<?php

namespace App\Modules\V1\User\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => (int) $this->id,
            'email' => $this->email,
            'email_masked' => $this->maskedEmail(),
            'username' => $this->username,
            'name' => $this->name,
            'address' => $this->whenNotNull($this->address),
            'phone' => $this->phone,
            'phone_masked' => Str::mask($this->phone, '*', 4, 4),
            'avatar' => $this->when(!empty($this->avatar), function () {
                return Storage::disk('public')->url("avatars/{$this->avatar}");
            }),
            'language' => $this->language,
            'role' => $this->getRoleNames(),
            'deleted_reason' => $this->whenNotNull($this->deleted_reason)
        ];
    }
    private function maskedEmail()
    {
        $domain = Str::after($this->email, '@');
        $email = Str::remove($domain, $this->email);
        return Str::mask($email, '*', ceil(Str::length($email) / 2)) . '@' . $domain;
    }
}
