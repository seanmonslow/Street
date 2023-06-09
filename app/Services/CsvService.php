<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
 
class CsvService {
    public function parseCsvFile(UploadedFile $csv) {
        $data = [];
        if (($handle = fopen($csv->getFileInfo(), 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, ",")) !== false)
            {
                $data[] = $row[0];
            }
            fclose($handle);
        }

        $parsedData = [];

        if (count($data) > 1) {
            for ($i = 1; $i < count($data); $i++) {
                $parsedData[] = $this->parseRow($data[$i]);
            }
        }

        $people = [];

        foreach ($parsedData as $parsedRow) {
            $people[] = $this->formatPerson($parsedRow['firstname'], $parsedRow['lastname'], $parsedRow['title']);
            if (isset($parsedRow['anothertitle'])) {
                if (isset($parsedRow['anotherfirstname']) && isset($parsedRow['anotherlastname'])) {
                    $people[] = $this->formatPerson($parsedRow['anotherfirstname'], $parsedRow['anotherlastname'], $parsedRow['anothertitle']);
                } else {
                    $people[] = $this->formatPerson(null, $parsedRow['lastname'], $parsedRow['anothertitle']);
                }
            }
        }

        return $people;
    }
    public function parseRow(string $name) : array {
        $regexPattern = '/^(?P<title>(?:Mr|Mrs|Mister|Miss|Ms|Master|Dr|Doctor|Prof(?:essor)?))\s+(?P<firstname>[\w.-]+)\s+(?P<lastname>[\w.-]+)$/';
        $multipleTitleRegexPattern = '/^(?P<title>(?:Mr|Mrs|Mister|Miss|Ms|Master|Dr|Doctor|Prof(?:essor)?))\s+(?:and|&)?\s+(?P<anothertitle>(?:Mr|Mrs|Mister|Miss|Ms|Master|Dr|Doctor|Prof(?:essor)?))\s+(?P<firstname>[\w.-]+)?\s+(?P<lastname>[\w.-]+)$/';
        $multipleTitleSurnameRegexPattern = '/^(?P<title>(?:Mr|Mrs|Mister|Miss|Ms|Master|Dr|Doctor|Prof(?:essor)?))\s+(?:and|&)?\s+(?P<anothertitle>(?:Mr|Mrs|Mister|Miss|Ms|Master|Dr|Doctor|Prof(?:essor)?))\s+(?P<lastname>[\w.-]+)$/';
        $multipleRegexPattern = '/^(?P<title>(?:Mr|Mrs|Mister|Miss|Ms|Master|Dr|Doctor|Prof(?:essor)?))\s+(?P<firstname>[\w.-]+)\s+(?P<lastname>[\w.-]+)\s+(?:and|&)?\s+(?P<anothertitle>(?:Mr|Mrs|Mister|Miss|Ms|Master|Dr|Doctor|Prof(?:essor)?))\s+(?P<anotherfirstname>[\w.-]+)\s+(?P<anotherlastname>[\w.-]+)$/';
        if (preg_match($regexPattern, $name, $matches)) {        
            return ['title' => $matches['title'], 'firstname' => $matches['firstname'], 'lastname' => $matches['lastname']];
        }
        if (preg_match($multipleTitleRegexPattern, $name, $matches)){
            return ['title' => $matches['title'], 'anothertitle' => $matches['anothertitle'], 'firstname' => $matches['firstname'], 'lastname' => $matches['lastname']];
        }
        if (preg_match($multipleTitleSurnameRegexPattern, $name, $matches)){
            return ['title' => $matches['title'], 'anothertitle' => $matches['anothertitle'], 'firstname' => null, 'lastname' => $matches['lastname']];
        }
        if (preg_match($multipleRegexPattern, $name, $matches)){
            return [
                'title' => $matches['title'], 
                'anothertitle' => $matches['anothertitle'], 
                'firstname' => $matches['firstname'], 
                'lastname' => $matches['lastname'], 
                'anotherfirstname' => $matches['anotherfirstname'],
                'anotherlastname' => $matches['anotherlastname']
            ];
        }
        return [];
    }

    public function formatPerson(string|null $firstname, string|null $lastname, string $title) : array {
        if (is_null($firstname)) {
            return [
                'firstname' => null,
                'initial' => $firstname,
                'surname' => $lastname,
                'title' => $title
            ];
        } else if (strlen($firstname) == 1 || (strlen($firstname) == 2 && substr($firstname, 1, 1) == ".")) {
            return [
                'firstname' => null,
                'initial' => $firstname,
                'surname' => $lastname,
                'title' => $title
            ];
        }
        return [
            'firstname' => $firstname,
            'initial' => null,
            'surname' => $lastname,
            'title' => $title
        ];
    }
}