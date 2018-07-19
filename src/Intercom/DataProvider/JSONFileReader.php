<?php
namespace Intercom\DataProvider;

class JSONFileReader implements ICustomersProvider
{
    private $filename;

    public function loadData()
    {
        $handle = fopen($this->filename, 'r');

        $data = [];
        while ($line = fgets($handle)) {
            $data[] = json_decode($line, /*assoc*/ true);
        }
        fclose($handle);

        return $data;
    }

    public function records()
    {
        // lazily load the JSON records
        if (!$this->data) {
            $this->data = $this->loadData();
        }

        return $this->data;
    }

    private function validateFilename($filename)
    {
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException('File not found.');
        }
    }

    public function __construct($filename)
    {
        $this->validateFilename($filename);

        $this->filename = $filename;
    }
}

