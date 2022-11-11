<?php

namespace app\core\interfaces;

interface DbTableInterface
{
    public function getDbTable(string $tableName): array;
    public function getAnchoredTableBody(string $primaryKey, array $tableData, string $path): string;
    public function getLinkedTableRow(string $link, array $rowData): string;
}
