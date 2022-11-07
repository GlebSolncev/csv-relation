<?php

namespace App\Services\CSV;

/**
 *
 */
class CSVScanner
{
    /**
     * @var string[]
     */
    protected $only = ['ID', 'EMAIL', 'CARD', 'PHONE'];

    /**
     * @return array
     */
    public function getData(): array
    {
        $f = fopen( 'php://stdin', 'r' );

        while( $line = fgets( $f ) ) {
            if($line === "\n") break;
            $res[] = str_getcsv(trim($line));
        }

        $headers = reset($res);
        array_shift($res);

        foreach($res as $line){
            $item = array_combine($headers, $line);
            $data[] = array_intersect_key($item, array_flip($this->only));
        }

        return $data;
    }
}