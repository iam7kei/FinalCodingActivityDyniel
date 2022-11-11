<?php

namespace app\core\elements;

class Table
{
    private string $rows;
    private string $header;
    private string $content;

    public function start()
    {
        echo '<table class="table">';
        return new Table();
    }

    public function end()
    {
        echo '</table>';
    }

    public function thead(string $row): string
    {
        return "<thead>$row</thead>";
    }
    public function th(string $header): string
    {
        return "<th>$header</th>";
    }
    public function tbody(string $body): string
    {
        return "<tbody>$body</tbody>";
    }

    public function row(string $row): string
    {
        return "<tr>$row</tr>";
    }

    public function td(string $data): string
    {
        return "<td> $data </td>";
    }
    public function anchor(string $link, string $data): string
    {
        return sprintf(
            "<a href='%s'>%s</a>",
            $link,
            $data
        );
    }
}
