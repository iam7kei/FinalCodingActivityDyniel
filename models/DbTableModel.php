<?php

namespace app\models;

use app\core\Database;
use app\core\elements\Table;
use app\core\interfaces\DbTableInterface;

class DbTableModel implements DbTableInterface
{
    private Database $db;
    private string $columns = '*';
    private string $path = '';
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    public function getDbTable(string $tableName): array
    {
        $statement = $this->db->prepare("SELECT $this->columns from $tableName");

        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAnchoredTableBody(string $linkAttribute, array $tableData, string $path = ''): string
    {
        $content = '';
        foreach ($tableData as $row) {
            $link = $path . $row[$linkAttribute];
            $content .= $this->getLinkedTableRow($link, $row);
        }
        return $content;
    }
    public function getTableBody(string $primaryKey, array $tableData): string
    {
        $content = '';
        foreach ($tableData as $row) {
            $content .= $this->getTableRow($row);
        }
        return $content;
    }

    public function getLinkedTableRow(string $link, array $rowData): string
    {
        $row = '';
        foreach ($rowData as $column => $value) {
            $row .= Table::td(Table::anchor($link, $value));
        }
        return Table::row($row);
    }

    public function getTableRow(array $rowData): string
    {
        $row = '';
        foreach ($rowData as $column => $value) {
            $row .= Table::td($value);
        }
        return Table::row($row);
    }
    public function getTableHeaders(array $rowData): string
    {
        $row = '';
        foreach ($rowData as $column => $value) {
            $row .= Table::th($value);
        }
        return Table::row($row);
    }

    public function setColumns(array $columns)
    {
        $this->columns = implode(',', $columns);
    }
}
