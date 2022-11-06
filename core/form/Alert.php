<?php

namespace app\core\form;

use app\core\Model;

class Alert
{
    public array $status;
    public function __construct(array $status = [])
    {
        $this->status = $status;
    }

    public function __toString()
    {
        return sprintf(
            '
            <div class="alert alert-%s" role="alert">
              %s
            </div>
        ',
            $this->status[0],
            $this->status[1]
        );
    }
}
