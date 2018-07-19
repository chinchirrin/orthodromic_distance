<?php
namespace Intercom\DataProvider;

class JSONFileReader implements ICustomersProvider
{
    private $filename;

    /**
     * Loads the customer records given the filename to the constructor.
     *
     * @return  array
     */
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

    /**
     * Returns an array of customer records
     *
     * @return  array
     */
    public function records()
    {
        // lazily load the JSON records
        if (!$this->data) {
            $this->data = $this->loadData();
        }

        return $this->data;
    }

    /**
     * Validate the provided filename is a file
     *
     * @param   string  $filename
     * @return  void
     */
    private function validateFilename($filename)
    {
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException('File not found.');
        }
    }

    /**
     * @throws  \InvalidArgumentException
     * @param   string  $filename
     */
    public function __construct($filename)
    {
        $this->validateFilename($filename);

        $this->filename = $filename;
    }
}

