<?php

return [

    // First is the layout we're injecting into.
    'cms::default' => [

        // Then the section we want to become part of.
        'content' => [

            // Then the view we wish to inject.
            'poll::poll' => [

                // Then we might specify certain configuration values.
                // 'order' => 0,
                // 'mode'  => \Lavender\Layout\View::INJECT_MODE_APPEND

            ]

        ]

    ]

];