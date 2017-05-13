--DESCRIPTION--

Test collections macros

--GIVEN--

$a = <>;

$b = <$a>;

$c = <"foo" => "bar">;

$d = <
    "hello" => "world",
    "goodbye" => "world",
>;

--EXPECT--

$a = (new \Pre\Collections\Collection);

$b = (new \Pre\Collections\Collection($a));

$c = (new \Pre\Collections\Collection(["foo" => "bar"]));

$d = (new \Pre\Collections\Collection(["hello" => "world",
    "goodbye" => "world",
]));
