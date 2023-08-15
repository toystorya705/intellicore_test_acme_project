<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RandomPasswordGenerator\RandomPasswordGenerator;
use CodeService\CodeService;

class RandomPasswordController extends Controller
{
    /**
     * Generate a random password for a user.
     *
     * @param Request $request
     * @return array
     */
    public function generateRandomPassword(Request $request)
    {
        // Allocate a code to the user
        $code = CodeService::allocateCodeToUser($request->user_id);

        if ($code) {
            return ['password' => $code];
        } else {
            return ['message' => "User already exists."];
        }
    }

    /**
     * Get the allocated code for a user.
     *
     * @param Request $request
     * @return array
     */
    public function getUserCode(Request $request)
    {
        // Retrieve the allocated code for the user
        $code = CodeService::getAllocateCodeToUser($request->user_id);

        if ($code) {
            return ['password' => $code];
        } else {
            return ['message' => "User '$request->user_id' not found."];
        }
    }

    /**
     * Check if a code exists.
     *
     * @param Request $request
     * @return array
     */
    public function checkCode(Request $request)
    {
        // Check if the provided code exists
        $codeExists = CodeService::checkCode($request->code);

        return ['result' => $codeExists];
    }

    /**
     * Delete the allocated code for a user.
     *
     * @param Request $request
     * @return array
     */
    public function deleteUserCode(Request $request)
    {
        // Delete the allocated code for the user
        $message = CodeService::deleteAllocateCodeToUser($request->user_id);

        if ($message) {
            return ['message' => "User code deleted successfully."];
        } else {
            return ['message' => "User '$request->user_id' not found."];
        }
    }

    /**
     * Reset the allocated code for a user.
     *
     * @param Request $request
     * @return array
     */
    public function resetUserCode(Request $request)
    {
        // Reset the allocated code for the user
        $code = CodeService::resetAllocatedCodeToUser($request->user_id);

        if ($code) {
            return ['message' => "Code '$request->user_id' reset successfully. New code: $code"];
        } else {
            return ['message' => "User '$request->user_id' not found."];
        }
    }
}
