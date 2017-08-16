--DESCRIPTION--

Test collections macros

--GIVEN--

({});

[{}];

({"foo" => "bar"});

[{"foo" => "bar"}];

[true, {"foo" => "bar"}];

return {};

$a = {};

return {$a2};

$b = {$a2};

return {"foo" => "bar"};

$c = {"foo" => "bar"};

return {
    "hello" => "world",
    "goodbye" => "world",
};

$d = {
    "hello" => "world",
    "goodbye" => "world",
};

{ $a, $b, $c } = ["a" => 1, "b" => 2, "c" => 3];

() => {}

["foo" => {"bar" => "baz"}]

--EXPECT--

( (new \Pre\Collections\Collection()));

[ (new \Pre\Collections\Collection())];

( (new \Pre\Collections\Collection(["foo" => "bar"])));

[ (new \Pre\Collections\Collection(["foo" => "bar"]))];

[true, (new \Pre\Collections\Collection(["foo" => "bar"]))];

return (new \Pre\Collections\Collection());

$a = (new \Pre\Collections\Collection());

return (new \Pre\Collections\Collection($a2));

$b = (new \Pre\Collections\Collection($a2));

return (new \Pre\Collections\Collection(["foo" => "bar"]));

$c = (new \Pre\Collections\Collection(["foo" => "bar"]));

return (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));

$d = (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));

['a' => $a, 'b' => $b, 'c' => $c] = ["a" => 1, "b" => 2, "c" => 3];

() => {}

["foo"=> (new \Pre\Collections\Collection(["bar" => "baz"]))]
