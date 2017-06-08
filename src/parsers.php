<?php

namespace Yay;

const ANGLE_LAYER_DELIMITERS = [
    "<" => 1,
    ">" => -1,
    "{" => 2,
    "}" => -2,
];

function angle_layer(): Parser
{
    return layer(ANGLE_LAYER_DELIMITERS);
}
