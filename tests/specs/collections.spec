--DESCRIPTION--

Test collections macros

--GIVEN--

$a1 = <>;

$a2 = {};

$b1 = <$a1>;

$b2 = {$a2};

$c1 = <"foo" => "bar">;

$c2 = {"foo" => "bar"};

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

$a1 = (new \Pre\Collections\Collection);

$a2 = (new \Pre\Collections\Collection);

$b1 = (new \Pre\Collections\Collection($a1));

$b2 = (new \Pre\Collections\Collection($a2));

$c1 = (new \Pre\Collections\Collection(["foo" => "bar"]));

$c2 = (new \Pre\Collections\Collection(["foo" => "bar"]));

$d1 = (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));

$d2 = (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));

['a' => $a, 'b' => $b, 'c' => $c] = ["a" => 1, "b" => 2, "c" => 3];

['a' => $a, 'b' => $b, 'c' => $c] = ["a" => 1, "b" => 2, "c" => 3];
