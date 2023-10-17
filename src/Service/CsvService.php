<?php
namespace App\Service;


class CsvService
{
    public static function importCsv($file)
    {
        // Open the CSV file for reading
        $handle = fopen($file, 'r');
        $email = [];
        if ($handle !== false) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                $dataTab = explode(';', $data[0]);
                $email[] = $dataTab[2];
            }

            // Close the CSV file
            fclose($handle);
        } else {
            // Handle the error if the file could not be opened
            echo 'Failed to open the CSV file.';
        }
        return $email;
    }
}
