<?php
/**
 * Created by JetBrains PhpStorm.
 * User: keshav
 * Date: 21/8/13
 * Time: 7:25 PM
 * To change this template use File | Settings | File Templates.
 */

class PhoneNumberRepository
{


    public function addPhoneNumber($std, $number, $status, $importId)
    {
        try {
            return DB::transaction(function () use ($number, $std, $status, $importId) {
                $phoneNumberInstance = new PhoneNumber();
                $phoneNumberInstance->number = $number;
                $phoneNumberInstance->std = $std;
                $phoneNumberInstance->phoneNumber = ltrim($std, "0") . $number;
                $phoneNumberInstance->status = $status;
                $phoneNumberInstance->save();
                $phoneNumberInstance->imports()->sync(array($importId));
                return $phoneNumberInstance;
            });
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }



    public function getPhoneNumbers($phoneNumber = null)
    {
        try {
            $query = PhoneNumber::orderBy('lastCheckedDate', 'desc')->orderBy('status', 'desc');
            if ($phoneNumber) {
                $query->where('phoneNumber', 'like', '%' . $phoneNumber . '%');
            }
            return $query->paginate(Constants::PAGING_COUNT);
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }


    public function getPhoneNumbersByPhoneNumbersList($phoneNumbersList)
    {
        try {
            return PhoneNumber::whereIn('phoneNumber', $phoneNumbersList)->get(array('phoneNumber', 'id'));
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function getPhoneNumberIdsByPhoneNumbers($phoneNumbersList)
    {
        try {
            return PhoneNumber::whereIn('phoneNumber', $phoneNumbersList)->get(array('id'));
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function insertNumbersInBatch($phoneNumbersList)
    {
        try {
            return PhoneNumber::insert($phoneNumbersList);
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

}
