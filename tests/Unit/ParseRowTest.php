<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CsvService;

class ParseRowTest extends TestCase
{
    public function test_parse_row_single(): void
    {
        $csvService = new CsvService();
        $parsedRow = $csvService->parseRow("Mr Jack Smith");
        $this->assertEquals('Mr', $parsedRow['title']);
        $this->assertEquals('Jack', $parsedRow['firstname']);
        $this->assertEquals('Smith', $parsedRow['lastname']);
    }

    public function test_parse_row_multiple_titles(): void
    {
        $csvService = new CsvService();
        $parsedRow = $csvService->parseRow("Mr and Mrs Jack Smith");
        $this->assertEquals('Mr', $parsedRow['title']);
        $this->assertEquals('Mrs', $parsedRow['anothertitle']);
        $this->assertEquals('Jack', $parsedRow['firstname']);
        $this->assertEquals('Smith', $parsedRow['lastname']);
    }

    public function test_parse_row_multiple_people(): void
    {
        $csvService = new CsvService();
        $parsedRow = $csvService->parseRow("Ms Jane Smith and Mr Jack Smith");
        $this->assertEquals('Ms', $parsedRow['title']);
        $this->assertEquals('Jane', $parsedRow['firstname']);
        $this->assertEquals('Smith', $parsedRow['lastname']);
        $this->assertEquals('Mr', $parsedRow['anothertitle']);
        $this->assertEquals('Jack', $parsedRow['anotherfirstname']);
        $this->assertEquals('Smith', $parsedRow['anotherlastname']);
    }
}
