<?php

namespace App\Modules\Common\Domain;

class Payload
{
    /** A creation command succeeded. */
    const STATUS_CREATED = 'CREATED';
    /** A deletion command succeeded. */
    const STATUS_DELETED = 'DELETED';
    /** There was a major error of some sort. */
    const STATUS_ERROR = 'ERROR';
    /** A query successfully returned results. */
    const STATUS_FOUND = 'FOUND';
    /** A new object is being returned. */
    const STATUS_NEW = 'NEW';
    /** A creation command failed. */
    const STATUS_NOT_CREATED = 'NOT_CREATED';
    /** A deletion command failed. */
    const STATUS_NOT_DELETED = 'NOT_DELETED';
    /** A query failed to return results. */
    const STATUS_NOT_FOUND = 'NOT_FOUND';
    /** A query failed to return results. */
    const STATUS_EVENT_NOT_FOUND = 'EVENT_NOT_FOUND';
    /** A query failed to return results because no active event. */
    const STATUS_NO_ACTIVE_EVENT = 'NO_ACTIVE_EVENT';
    /** A slug query failed to return results. */
    const STATUS_SLUG_NOT_FOUND = 'SLUG_NOT_FOUND';
    /** A asset query failed to return results. */
    const STATUS_ASSET_NOT_FOUND = 'ASSET_NOT_FOUND';
    /** An update command failed. */
    const STATUS_NOT_UPDATED = 'NOT_UPDATED';
    /** User input was not valid. */
    const STATUS_NOT_VALID = 'NOT_VALID';
    /** An update command succeeded. */
    const STATUS_UPDATED = 'UPDATED';
    /** An restore command succeeded. */
    const STATUS_RESTORED = 'RESTORED';
    /** User input was valid. */
    const STATUS_VALID = 'VALID';
    /** Unaothorized User */
    const STATUS_UNAUTHORIZED = 'UNAUTHORIZED';
    /** Forbidden access */
    const STATUS_FORBIDDEN = 'FORBIDDEN';
    /** Determine if resource isnt owner */
    const STATUS_NOT_OWNER = 'NOT_OWNER';
    /** Determine if resource is protected */
    const STATUS_PROTECTED_RESOURCE = 'PROTECTED_RESOURCE';
    /** Determine if resources has no data */
    const STATUS_NO_DATA = 'NO_DATA';
    /** Download File */
    const STATUS_DOWNLOAD_AND_REMOVE = 'DOWNLOAD_AND_REMOVE';
    /** Import File */
    const STATUS_IMPORTED = 'IMPORTED';
    /** Expired Data */
    const STATUS_EXPIRED = 'EXPIRED';
    /** Determine if already has an record */
    const STATUS_HAS_RECORD = 'HAS_RECORD';

    public function __construct(string $status, array $result = [])
    {
        $this->status = $status;
        $this->result = $result;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}
