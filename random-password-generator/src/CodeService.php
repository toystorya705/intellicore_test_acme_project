<?php

namespace CodeService;

use App\Models\AccessCode;
use RandomPasswordGenerator\RandomPasswordGenerator;


class CodeService
{
    /**
     * Allocate a code to a user if not already allocated.
     *
     * @param int $userId
     * @return string|null New code value or null if already allocated
     */
    public static function allocateCodeToUser($userId)
    {
        if (AccessCode::where('user_id', $userId)->first()) {
            return null; // Code already allocated
        }
        
        // Generate a new code
        $newCodeValue = RandomPasswordGenerator::generateRandomPasswordWithCheckInDatabase();

        // Create a new Code record and associate it with the user
        AccessCode::insert([
            'access_code' => $newCodeValue,
            'user_id' => $userId,
            "created_at" => now()
        ]);

        return $newCodeValue;
    }

    /**
     * Reset an allocated code for a user.
     *
     * @param int $userId
     * @return string|null New code value or null if not found
     */
    public static function resetAllocatedCodeToUser($userId)
    {
        // Generate a new code
        $resource = AccessCode::where('user_id', $userId)->first();

        if ($resource) {
            $newCodeValue = RandomPasswordGenerator::generateRandomPasswordWithCheckInDatabase();

            // Update the existing Code record for the user
            $resource->update([
                'access_code' => $newCodeValue,
                'user_id' => $userId,
                "created_at" => now()
            ]);

            return $newCodeValue;
        } else {
            return null; // User not found
        }
    }

    /**
     * Check if a code exists.
     *
     * @param string $code
     * @return bool
     */
    public static function checkCode($code)
    {
        $resource = AccessCode::where('access_code', $code)->first();
        return (bool) $resource;
    }

    /**
     * Get the allocated code for a user.
     *
     * @param int $userId
     * @return AccessCode|null
     */
    public static function getAllocateCodeToUser($userId)
    {
        $resource = AccessCode::where('user_id', $userId)->first();
        return $resource;
    }

    /**
     * Delete the allocated code for a user.
     *
     * @param int $userId
     * @return string|null Success message or null if not found
     */
    public static function deleteAllocateCodeToUser($userId)
    {
        $resource = AccessCode::where('user_id', $userId)->first();

        if ($resource) {
            $resource->delete();
            return "Code '$userId' deleted successfully.";
        } else {
            return null; // User not found
        }
    }

    // Other methods for interacting with codes
}
