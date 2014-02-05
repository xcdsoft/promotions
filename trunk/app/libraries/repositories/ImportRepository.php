<?php
/**
 * Created by JetBrains PhpStorm.
 * User: keshav
 * Date: 5/9/13
 * Time: 11:10 AM
 * To change this template use File | Settings | File Templates.
 */

class ImportRepository
{
    public function createImportStatus($name, $filePath, $status, $importCount, $newNumberCount, $sentEmailCount,
                                       $sentSmsCount, $invalidCount, $otherCount, $priority)
    {
        try {
            $import = new Import();
            $import->name = $name;
            $import->filePath = $filePath;
            $import->status = $status;
            $import->importCount = $importCount;
            $import->newNumberCount = $newNumberCount;
            $import->sentEmailCount = $sentEmailCount;
            $import->sentSmsCount = $sentSmsCount;
            $import->invalidCount = $invalidCount;
            $import->otherCount = $otherCount;
            $import->priority = $priority;
            $import->save();
            return $import;
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }


    public function getImportToProcess($priority)
    {
        try {
            $importRecord = Import::where('status', '=', Constants::UPLOADED)->
                where('priority', '>=', $priority)->orderBy('created_at')->first();
            if (is_null($importRecord))
                return null;
            return $importRecord;
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function updateImportRecord($id, $status = Constants::UPLOADED, $importCount = null, $newNumberCount = null,
                                       $cleanCount = null, $invalidCount = null,
                                       $ringingCount = null, $otherCount = null, $priority = null, $s3Key = null,
                                       $forceSetS3Null = false, $isExportSateChanged = false)
    {
        try {
            $importInstance = Import::where('id', '=', $id)->first();
            if (!is_null($status))
                $importInstance->status = $status;
            if (!is_null($importCount))
                $importInstance->importCount = $importCount;
            if (!is_null($newNumberCount))
                $importInstance->newNumberCount = $newNumberCount;
            if (!is_null($cleanCount))
                $importInstance->cleanCount = $cleanCount;
            if (!is_null($invalidCount))
                $importInstance->invalidCount = $invalidCount;
            if (!is_null($ringingCount))
                $importInstance->ringingCount = $ringingCount;
            if (!is_null($otherCount))
                $importInstance->otherCount = $otherCount;
            if (!is_null($priority))
                $importInstance->priority = $priority;
            if (!is_null($s3Key) || $forceSetS3Null)
                $importInstance->s3Key = $s3Key;
            if ($isExportSateChanged) {
                $importInstance->isExportStateChanged = true;
            }
            Log::info('Import instance before updating is ', $importInstance->toArray());
            $importInstance->updated_at = new DateTime();
            $importInstance->save();
            Log::info('Import instance after updating is ', $importInstance->toArray());
            return $importInstance;
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function getImportRecords()
    {
        try {
            return Import::orderBy('created_at', 'desc')->orderBy('status', 'desc')->paginate(Constants::PAGING_COUNT);
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }

    public function getImportRecord($importId)
    {
        try {
            return Import::where('id', '=', $importId)->first();
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }

    }

    public function syncPhoneNumbersAndImport($importId, $phoneNumberIds, $detachExisting = true)
    { //
        try {
            $import = Import::where('id', '=', $importId)->first();
            $import->phoneNumbers()->sync($phoneNumberIds, $detachExisting);
        } catch (Exception $e) {
            Log::error($e);
            throw $e;
        }
    }



}
