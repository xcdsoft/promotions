<?php
/**
 * Created by JetBrains PhpStorm.
 * User: keshav
 * Date: 21/8/13
 * Time: 7:26 PM
 * To change this template use File | Settings | File Templates.
 */

class PhoneNumberService
{

    private $phoneNumberRepo;
    private $contactDataRepo;
    private $importRepo;

    public function __construct()
    {
        $this->phoneNumberRepo = new PhoneNumberRepository();
        $this->contactDataRepo = new ContactsRepository();
        $this->importRepo = new ImportRepository();
    }


    private function getPhoneNumberAndStd($phoneNumber)
    {
        if (empty($phoneNumber))
            return "";
        $data = explode('-', $phoneNumber);
        if (isset($data[1]) && preg_match("/^\\d{5,10}$/", $data[1])) {
            return $data;
        }
    }

    private function getMobile($mobile)
    {
        if (empty($mobile)) {
            return "";
        }
        if (preg_match("/^\\d{10}$/", $mobile)) {
            return $mobile;
        }
        return "";
    }


    private function parseCSV($filePath)
    {
        $csvFile = new CSV($filePath);

        $indexes = array();

        $phoneNumberArray = array();
        foreach ($csvFile as $rowKey => $row) {
            //parse headers
            if ($rowKey == 0) {
                foreach ($row as $columnKey => $column) {

                    if (strcasecmp($column, "Mobile 1") == 0) {
                        $indexes['mobile1'] = $columnKey;
                    } elseif (strcasecmp($column, "Mobile 2") == 0) {
                        $indexes['mobile2'] = $columnKey;
                    } elseif (strcasecmp($column, "Mobile 3") == 0) {
                        $indexes['mobile3'] = $columnKey;
                    } elseif (strcasecmp($column, "LandLine 1") == 0) {
                        $indexes['landLine1'] = $columnKey;
                    } elseif (strcasecmp($column, "LandLine 2") == 0) {
                        $indexes['landLine2'] = $columnKey;
                    } elseif (strcasecmp($column, "LandLine 3") == 0) {
                        $indexes['landLine3'] = $columnKey;
                    } elseif (strcasecmp($column, "name") == 0) {
                        $indexes['name'] = $columnKey;
                    } elseif (strcasecmp($column, "email") == 0) {
                        $indexes['email'] = $columnKey;
                    } elseif (strcasecmp($column, "age") == 0) {
                        $indexes['age'] = $columnKey;
                    } elseif (strcasecmp($column, "income") == 0) {
                        $indexes['income'] = $columnKey;
                    } elseif (strcasecmp($column, "city") == 0) {
                        $indexes['city'] = $columnKey;
                    } elseif (strcasecmp($column, "source") == 0) {
                        $indexes['source'] = $columnKey;
                    } elseif (strcasecmp($column, "education") == 0) {
                        $indexes['education'] = $columnKey;
                    }
                }
            } else {
                $isRowEmpty = true;
                foreach ($indexes as $rowItem) {
                    if (!empty($row[$rowItem])) {
                        $isRowEmpty = false;
                        break;
                    }
                }
                if ($isRowEmpty)
                    continue;
                foreach ($indexes as $key => $index) {
                    $phoneNumberArray[$rowKey][$key] = $row[$index];
                }
            }
        }

        $csvFile = null;

        return $phoneNumberArray;
    }

    public function importPhoneNumbers($filePath, $importId)
    {
        try {
            $insertCount = 0;
            $duplicateCount = 0;
            $errorCount = 0;
            //Parsing file , it will return list of contact data with key value map
            $contactDetailsArray = $this->parseCSV($filePath);
            $contactsArray = array();
            $mobile1List = array();
            $mobile2List = array();
            $mobile3List = array();
            $landLine1List = array();
            $landLine2List = array();
            $landLine3List = array();
            $currentDate = new DateTime();
            // creating contacts to insert and filtering numbers
            foreach ($contactDetailsArray as $contactData) {
                $mobile1Id = null;
                $mobile2Id = null;
                $mobile3Id = null;
                $landLine1Id = null;
                $landLine2Id = null;
                $landLine3Id = null;

                $name = empty($contactData['name']) ? "" : utf8_encode($contactData['name']);
                $email = empty($contactData['email']) ? null : utf8_encode($contactData['email']);
                $age = empty($contactData['age']) ? null : utf8_encode($contactData['age']);
                $income = empty($contactData['income']) ? null : utf8_encode($contactData['income']);
                $city = empty($contactData['city']) ? null : utf8_encode($contactData['city']);
                $source = empty($contactData['source']) ? null : utf8_encode($contactData['source']);
                $education = empty($contactData['education']) ? null : utf8_encode($contactData['education']);
                $mobile1 = empty($contactData['mobile1']) ? null : utf8_encode($contactData['mobile1']);
                $mobile2 = empty($contactData['mobile2']) ? null : utf8_encode($contactData['mobile2']);
                $mobile3 = empty($contactData['mobile3']) ? null : utf8_encode($contactData['mobile3']);
                $landLine1 = empty($contactData['landLine1']) ? null : utf8_encode($contactData['landLine1']);
                $landLine2 = empty($contactData['landLine2']) ? null : utf8_encode($contactData['landLine2']);
                $landLine3 = empty($contactData['landLine3']) ? null : utf8_encode($contactData['landLine3']);


                if (!empty($contactData['mobile1'])) {
                    $mobileNumber = $this->getMobile($contactData['mobile1']);
                    if (empty($mobileNumber)) {
                        ++$errorCount;
                    } else {
                        if (array_key_exists($mobileNumber, $mobile1List)) {
                            ++$duplicateCount;
                        } else {
                            $mobile1List[$mobileNumber] = array('std' => null, 'number' => $mobileNumber,
                                'phoneNumber' => $mobileNumber, 'status' => Constants::NOT_VERIFIED,
                                'created_at' => $currentDate, 'updated_at' => $currentDate);
                        }
                    }
                }


                $contactsArray[] = array('name' => $name, 'email' => $email, 'age' => $age, 'income' => $income,
                    'city' => $city, 'source' => $source, 'education' => $education, 'mobile1' => $mobile1, 'mobile2' => $mobile2,
                    'mobile3' => $mobile3, 'landLine1' => $landLine1, 'landLine2' => $landLine2,
                    'landLine3' => $landLine3, 'landLine1Id' => null, 'landLine2Id' => null, 'landLine3Id' => null,
                    'mobile1Id' => null, 'mobile2Id' => null, 'mobile3Id' => null, 'importId' => $importId,
                    'created_at' => $currentDate, 'updated_at' => $currentDate);

            }

            try {
                //inserting phone Numbers in batch
                $insertedIds = array();

                $mobileNumbersAndIdsMap = array();

                for ($index = 0; $index < count($mobile1List); $index += Constants::BATCH_SIZE) {
                    $batch = array_slice($mobile1List, $index, Constants::BATCH_SIZE, true);
                    $phoneNumberList = array_keys($batch);
                    $existingPhoneNumbers = $this->phoneNumberRepo->getPhoneNumbersByPhoneNumbersList($phoneNumberList);
                    $alreadyExistingPhoneNumbers = $existingPhoneNumbers;

                    if (!$existingPhoneNumbers->isEmpty()) {
                        foreach ($existingPhoneNumbers as $numberRow) {
                            $mobileNumbersAndIdsMap[$numberRow['phoneNumber']] = $numberRow['id'];
                        }

                        $existingPhoneNumbers = $existingPhoneNumbers->lists('phoneNumber');
                    } else {
                        $existingPhoneNumbers = array();
                    }

                    $numbersToInsert = array_except($batch, $existingPhoneNumbers);
                    $numbersToInsertCount = count($numbersToInsert);

                    if ($numbersToInsertCount > 0) {
                        if (!$this->phoneNumberRepo->insertNumbersInBatch($numbersToInsert)) {
                            Log::error('Unable to insert Phone number is batch where numbers are ' . print_r($numbersToInsert, true));
                            throw new InvalidArgumentException('Unable to in insert phone numbers');
                        }

                        $insertedNumberCount = $numbersToInsertCount;
                        $insertCount += $insertedNumberCount;
                        $duplicateCount += count($batch) - $insertedNumberCount;

                        $newNumbers = $this->phoneNumberRepo->getPhoneNumbersByPhoneNumbersList(array_keys($numbersToInsert));
                        if (!$newNumbers->isEmpty()) {
                            $insertedIds = array_merge($insertedIds, $newNumbers->lists('id'));
                            foreach ($newNumbers as $numberRow) {
                                $mobileNumbersAndIdsMap[$numberRow['phoneNumber']] = $numberRow['id'];
                            }
                        }
                    } else {
                        $duplicateCount += count($batch);
                        $insertedIds = array_merge($insertedIds, $alreadyExistingPhoneNumbers->lists('id'));
                    }
                }

                //phone number insertion completed

                $mobileNumbersAndIdsMapKeys = array_keys($mobileNumbersAndIdsMap);
                foreach ($contactsArray as $key => $row) {
        if ($row['mobile1'] != null && is_int(($numberKey = array_search($row['mobile1'], $mobileNumbersAndIdsMapKeys)))
                        && strcmp($mobileNumbersAndIdsMapKeys[$numberKey], $row['mobile1']) == 0
                    ) {
                        $contactsArray[$key]['mobile1Id'] = $mobileNumbersAndIdsMap[$row['mobile1']];
                    }

                }

                unset($mobileNumbersAndIdsMapKeys);

                $phoneNumberRepoObject = $this->phoneNumberRepo;
                $contactDataRepo = $this->contactDataRepo;
                $importRepo = $this->importRepo;
                $insertAndDuplicateCountArray = DB::transaction(function () use (
                    $contactsArray, $insertedIds,
                    $phoneNumberRepoObject, $importId, $importRepo, $insertCount, $duplicateCount, $errorCount,
                    $contactDataRepo
                ) {

                    //break the array into chunks of 500 records. MySQL parameters too many exception is thrown else.
                    $contactsArrayChunk = array_chunk($contactsArray, 500, true);

                    //insert chunks of data
                    foreach ($contactsArrayChunk as $contactsToInsert) {
                        $isInserted = $contactDataRepo->addContacts($contactsToInsert);

                        if (!$isInserted) {
                            Log::error("Unable to insert contacts");
                            throw new Exception("Unable to insert contacts");
                        }
                    }

                    //sync all phone numbers with import
                    $phoneIdChunks = array_chunk($insertedIds, 500, true);

                    foreach ($phoneIdChunks as $phoneIdsToInsert) {
                        $importRepo->syncPhoneNumbersAndImport($importId, $phoneIdsToInsert, false);
                    }

                    $importRepo->updateImportRecord($importId, Constants::IMPORTED, $insertCount + $duplicateCount + $errorCount, $insertCount);
                });

            } catch (Exception $e) {
                Log::error('Error while importing data');
                throw $e;
            }

            return array('insertCount' => $insertAndDuplicateCountArray['insertCount'], 'duplicateCount' =>
                $insertAndDuplicateCountArray['duplicateCount'], 'errorCount' => $errorCount);
        } catch (Exception $e) {
            Log::error('Error while parsing file');
            throw $e;
        }
    }



}
