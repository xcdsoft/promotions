<?php
/**
 * Created by JetBrains PhpStorm.
 * User: keshav
 * Date: 12/9/13
 * Time: 11:04 AM
 * To change this template use File | Settings | File Templates.
 */

class ContactsRepository
{
    public function addContact($name, $email, $age, $income, $city,  $education, $mobile1,  $mobile1Id, $mobile1Status, $importId)
    {
        try {
            $contactData = new Contacts();
            $contactData->name = $name;
            $contactData->email = $email;
            $contactData->age = $age;
            $contactData->income = $income;
            $contactData->city = $city;
            $contactData->education = $education;
            $contactData->mobile1 = $mobile1;
            $contactData->mobile1Id = $mobile1Id;
            $contactData->mobile1Status = $mobile1Status;
            $contactData->importId = $importId;
            $contactData->save();
            return $contactData;
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }

    }

    public function  updateContact($id, $data)
    {
        try {
            Contacts::where('id', '=', $id)->update($data);
            return Contacts::where('id', '=', $id)->first();
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function addContacts($data)
    {
        try {
            $records = Contacts::insert($data);
            return $records;
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function getContacts($importId)
    {
        try {
            return Contacts::where('importId', '=', $importId)->get();
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function updatePhoneStatuses($importId)
    {
        try {
//
            DB::Table('contacts')
                ->join('phoneNumbers', 'phoneNumbers.id', '=', 'contacts.mobile1Id')
                ->where('contacts.importId', $importId)
                ->update(array(
                    'mobile1Status' => DB::Raw('"phoneNumbers"."status"'),
                    'mobile1DNCStatus' => DB::Raw('"phoneNumbers"."isDNC"'),

                ));

            return true;
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

}
