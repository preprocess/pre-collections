--DESCRIPTION--

Test collections macros

--GIVEN--

return [true, {"foo" => "bar"}];

return [true, <"foo" => "bar">];

return {};

return <>;

$a1 = <>;

$a2 = {};

return <$a1>;

return {$a2};

$b1 = <$a1>;

$b2 = {$a2};

return <"foo" => "bar">;

return {"foo" => "bar"};

$c1 = <"foo" => "bar">;

$c2 = {"foo" => "bar"};

return <
    "hello" => "world",
    "goodbye" => "world",
>;

return {
    "hello" => "world",
    "goodbye" => "world",
};

$d1 = <
    "hello" => "world",
    "goodbye" => "world",
>;

$d2 = {
    "hello" => "world",
    "goodbye" => "world",
};

< $a, $b, $c > = ["a" => 1, "b" => 2, "c" => 3];

{ $a, $b, $c } = ["a" => 1, "b" => 2, "c" => 3];

--EXPECT--


return [true, (new \Pre\Collections\Collection(["foo" => "bar"]))];

return [true, (new \Pre\Collections\Collection(["foo" => "bar"]))];

return (new \Pre\Collections\Collection);

return (new \Pre\Collections\Collection);

$a1 = (new \Pre\Collections\Collection);

$a2 = (new \Pre\Collections\Collection);

return (new \Pre\Collections\Collection($a1));

return (new \Pre\Collections\Collection($a2));

$b1 = (new \Pre\Collections\Collection($a1));

$b2 = (new \Pre\Collections\Collection($a2));

return (new \Pre\Collections\Collection(["foo" => "bar"]));

return (new \Pre\Collections\Collection(["foo" => "bar"]));

$c1 = (new \Pre\Collections\Collection(["foo" => "bar"]));

$c2 = (new \Pre\Collections\Collection(["foo" => "bar"]));

return (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));

return (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));

$d1 = (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));

$d2 = (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));

['a' => $a, 'b' => $b, 'c' => $c] = ["a" => 1, "b" => 2, "c" => 3];

['a' => $a, 'b' => $b, 'c' => $c] = ["a" => 1, "b" => 2, "c" => 3];
