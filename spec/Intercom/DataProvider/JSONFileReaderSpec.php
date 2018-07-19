<?php

namespace spec\Intercom\DataProvider;

use Intercom\DataProvider\JSONFileReader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JSONFileReaderSpec extends ObjectBehavior
{
    function it_should_throw_exception_if_file_not_found()
    {
        $filename = 'fake/file.txt';
        $this->beConstructedWith($filename);
        $this->shouldThrow('\InvalidArgumentException')
             ->duringInstantiation();
    }
}

