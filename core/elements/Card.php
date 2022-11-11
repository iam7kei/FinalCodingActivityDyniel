<?php

namespace app\core\elements;
namespace app\core\elements;

class Card
{
    public function renderCard(array $keys, array $data)
    {
        return sprintf(
            "
                    <div class='card' style='width: 18rem;'>
                      <div class='card-body'>
                        <h5 class='card-title'>%s</h5>
                        <h6 class='card-subtitle mb-2 text-muted'>%s</h6>
                        <p class='card-text'>%s</p>
                      </div>
                    </div>
        
    ",
            $data[$keys[0]],
            $data[$keys[1]],
            $data[$keys[2]],
        );
    }
}
