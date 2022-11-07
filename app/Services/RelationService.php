<?php

namespace App\Services;

use App\Services\CSV\CSVScanner;

/**
 *
 */
class RelationService
{
    /**
     * @return void
     */
    public function withWithCSV(): void
    {
        $scanner = new CSVScanner();
        $data = $scanner->getData();

        $result = $this->createRelations($data);
        fputs(STDOUT, implode("\n", $result));
    }

    /**
     * @param array $data
     * @return array
     */
    public function createRelations(array $data): array
    {
        $relations[] = "ID,PARENT_ID";
        foreach ($data as $key => $item) {
            if ($key === 0) {
                $relations[] = $data[$key]['ID'].','.$data[$key]['ID'];
                continue;
            }

            $parentId = $this->getParentId($data, $key, $item);
            $data[$key]['PARENT_ID'] = $parentId;

            $relations[] = $data[$key]['ID'].','.$data[$key]['PARENT_ID'];
        }
        return $relations;
    }

    /**
     * @param array $data
     * @param       $key
     * @param array $item
     * @return int
     */
    protected function getParentId(array $data, $key, array $item): int
    {
        unset($data[$key]);
        foreach ($data as $parentItem) {
            if (array_intersect_key(array_flip($parentItem), array_flip($item))) {
                if (key_exists('PARENT_ID', $parentItem)) {
                    $result = (int) $parentItem['PARENT_ID'];
                } else {
                    $result = (int) $parentItem['ID'];
                }
                return $result;
            }
        }

        return (int) $item['ID'];
    }
}