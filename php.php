#!/usr/bin/env php
<?php

/**
 * convert a string to its php representation
 * @param string $subj
 * @return string
 */
function quine($subj) {
	return "<<<eoquinePhp\n" . str_replace(array('\\', "\$", ), array('\\\\', '\$', ), $subj) . "\neoquinePhp\n";
}

function quinePhp() {
	$beforeThePhp = <<<'hs'
module Main (main)
where

import Data.List.Utils
import System.Environment

showlist :: Show a => Int -> [a] -> String
showlist indent xs = "[\n" ++ listIndent ++ listIndenter xs ++ "\n" ++ listIndent ++ "]"
	where
		listIndent = take indent (repeat '\t')
		listIndenter ys = join (",\n" ++ listIndent) (map show ys)

rtrim :: String -> String
rtrim = takeWhileList fn
	where
		fn ('\n':[]) = False
		fn _ = True

phpBeforeTheHs :: String
phpBeforeTheHs = unlines [ 
hs;

	$beforeTheData = <<<'hs'
phpAfterTheData :: String
phpAfterTheData = unlines 
hs;
}

$the_hs = <<<'hs'
module Main (main)
where

import Data.List.Utils
import System.Environment

showlist :: Show a => Int -> [a] -> String
showlist indent xs = "[\n" ++ listIndent ++ listIndenter xs ++ "\n" ++ listIndent ++ "]"
	where
		listIndent = take indent (repeat '\t')
		listIndenter ys = join (",\n" ++ listIndent) (map show ys)

rtrim :: String -> String
rtrim = takeWhileList fn
	where
		fn ('\n':[]) = False
		fn _ = True

phpBeforeTheHs :: String
phpBeforeTheHs = unlines [
	"#!/usr/bin/env php",
	"<?php",
	"",
	"/**",
	" * convert a string to its php representation",
	" * @param string $subj",
	" * @return string",
	" */",
	"function quine($subj) {",
	"\treturn \"<<<eoquinePhp\\n\" . str_replace(array('\\\\', \"\\$\", ), array('\\\\\\\\', '\\$', ), $subj) . \"\\neoquinePhp\\n\";",
	"}",
	"",
	"$the_hs = <<<'hs'"
	]
phpAfterTheData :: String
phpAfterTheData = unlines [
	"$the_data = quine($before_the_hs) . \";\\n\\$before_the_data = \" . quine($before_the_data) . \";\\n\\$after_the_data = \" . quine($after_the_data) . \";\\n\";",
	"if (array_key_exists(1, $argv) && $argv[1] == 'php')",
	"\techo $before_the_hs, $the_hs, $before_the_data, $the_data, $after_the_data;",
	"elseif (array_key_exists(1, $argv) && $argv[1] == 'hs')",
	"\techo $the_hs;",
	"elseif (array_key_exists(1, $argv) && $argv[1] == 'cabal')",
	"\techo <<<cabal",
	"Name:          quine",
	"Build-Type:    Simple",
	"Version:       0.0",
	"Cabal-Version: >=1.2",
	"",
	"Executable quine",
	"   Main-is:          hs.hs",
	"   Build-Depends:    base>=3, MissingH",
	"   Ghc-options:       -Wall",
	"",
	"cabal;",
	"else",
	"\techo \"try php, hs or cabal",
	"\";"
	]
quine :: IO()
quine = do
	let m = unlines ["I","am","happy"]
	let beforeThePhp = unlines [
		"module Main (main)",
		"where",
		"",
		"import Data.List.Utils",
		"import System.Environment",
		"",
		"showlist :: Show a => Int -> [a] -> String",
		"showlist indent xs = \"[\\n\" ++ listIndent ++ listIndenter xs ++ \"\\n\" ++ listIndent ++ \"]\"",
		"\twhere",
		"\t\tlistIndent = take indent (repeat '\\t')",
		"\t\tlistIndenter ys = join (\",\\n\" ++ listIndent) (map show ys)",
		"",
		"rtrim :: String -> String",
		"rtrim = takeWhileList fn",
		"\twhere",
		"\t\tfn ('\\n':[]) = False",
		"\t\tfn _ = True",
		"",
		"phpBeforeTheHs :: String",
		"phpBeforeTheHs = unlines "
		]
	let beforeTheData = unlines [
		"phpAfterTheData :: String",
		"phpAfterTheData = unlines "
		]
	let moreHs = unlines [
		"",
		"quine :: IO()",
		"quine = do"
		]
	let afterTheData = unlines [
		"\tputStr $ rtrim beforeThePhp",
		"\tputStrLn $ showlist 1 (lines phpBeforeTheHs)",
		"\tputStr (rtrim beforeTheData)",
		"\tputStr (showlist 1 (lines phpAfterTheData))",
		"\tputStr moreHs",
		"\tputStrLn $ \"\\tlet m = unlines \" ++ show (lines m)",
		"\tputStrLn $ \"\\tlet beforeThePhp = unlines \" ++ showlist 2 (lines beforeThePhp)",
		"\tputStrLn $ \"\\tlet beforeTheData = unlines \" ++ showlist 2 (lines beforeTheData)",
		"\tputStrLn $ \"\\tlet moreHs = unlines \" ++ showlist 2 (lines moreHs)",
		"\tputStrLn $ \"\\tlet afterTheData = unlines \" ++ showlist 2 (lines afterTheData)",
		"\tputStrLn afterTheData",
		"",
		"multifiddle :: (a -> b -> c -> c) -> [a] -> [b] -> c -> c",
		"multifiddle f xs ys i = foldr (\\g -> g) i (zipWith f xs ys)",
		"",
		"php_replace :: [String] -> [String] -> String -> String",
		"php_replace = multifiddle replace",
		"",
		"phpise :: String -> String",
		"phpise = php_replace [ \"$\", \"\\\\\" ] [ \"\\\\$\", \"\\\\\\\\\" ]",
		"-- phpise = php_replace [ \"\\n\", \"$\", \"\\t\", \"\\\"\", \"\\\\\" ] [ \"\\\\n\", \"\\\\$\", \"\\\\t\", \"\\\\\\\"\", \"\\\\\\\\\" ]",
		"",
		"quinePhp :: String -> String",
		"-- quinePhp php = \"\\\"\" ++ phpise php ++ \"\\\"\"",
		"quinePhp php = \"<<<eoquinePhp\\n\" ++ phpise php ++ \"\\neoquinePhp\\n\"",
		"",
		"makeOutput :: [String] -> IO()",
		"makeOutput [\"php\"] = do",
		"\tlet phpBeforeTheData = \"\\nhs;\\n$before_the_hs = \"",
		"\tlet theData = quinePhp phpBeforeTheHs ++ \";\\n$before_the_data = \" ++ quinePhp phpBeforeTheData ++ \";\\n$after_the_data = \" ++ quinePhp phpAfterTheData ++ \";\\n\"",
		"\tputStr phpBeforeTheHs",
		"\tquine",
		"\tputStr phpBeforeTheData",
		"\tputStr theData",
		"\tputStr phpAfterTheData",
		"makeOutput _ = quine",
		"",
		"main :: IO()",
		"main = getArgs >>= makeOutput"
		]
	putStr $ rtrim beforeThePhp
	putStrLn $ showlist 1 (lines phpBeforeTheHs)
	putStr (rtrim beforeTheData)
	putStr (showlist 1 (lines phpAfterTheData))
	putStr moreHs
	putStrLn $ "\tlet m = unlines " ++ show (lines m)
	putStrLn $ "\tlet beforeThePhp = unlines " ++ showlist 2 (lines beforeThePhp)
	putStrLn $ "\tlet beforeTheData = unlines " ++ showlist 2 (lines beforeTheData)
	putStrLn $ "\tlet moreHs = unlines " ++ showlist 2 (lines moreHs)
	putStrLn $ "\tlet afterTheData = unlines " ++ showlist 2 (lines afterTheData)
	putStrLn afterTheData

multifiddle :: (a -> b -> c -> c) -> [a] -> [b] -> c -> c
multifiddle f xs ys i = foldr (\g -> g) i (zipWith f xs ys)

php_replace :: [String] -> [String] -> String -> String
php_replace = multifiddle replace

phpise :: String -> String
phpise = php_replace [ "$", "\\" ] [ "\\$", "\\\\" ]
-- phpise = php_replace [ "\n", "$", "\t", "\"", "\\" ] [ "\\n", "\\$", "\\t", "\\\"", "\\\\" ]

quinePhp :: String -> String
-- quinePhp php = "\"" ++ phpise php ++ "\""
quinePhp php = "<<<eoquinePhp\n" ++ phpise php ++ "\neoquinePhp\n"

makeOutput :: [String] -> IO()
makeOutput ["php"] = do
	let phpBeforeTheData = "\nhs;\n$before_the_hs = "
	let theData = quinePhp phpBeforeTheHs ++ ";\n$before_the_data = " ++ quinePhp phpBeforeTheData ++ ";\n$after_the_data = " ++ quinePhp phpAfterTheData ++ ";\n"
	putStr phpBeforeTheHs
	quine
	putStr phpBeforeTheData
	putStr theData
	putStr phpAfterTheData
makeOutput _ = quine

main :: IO()
main = getArgs >>= makeOutput


hs;
$before_the_hs = <<<eoquinePhp
#!/usr/bin/env php
<?php

/**
 * convert a string to its php representation
 * @param string \$subj
 * @return string
 */
function quine(\$subj) {
	return "<<<eoquinePhp\\n" . str_replace(array('\\\\', "\\\$", ), array('\\\\\\\\', '\\\$', ), \$subj) . "\\neoquinePhp\\n";
}

\$the_hs = <<<'hs'

eoquinePhp
;
$before_the_data = <<<eoquinePhp

hs;
\$before_the_hs = 
eoquinePhp
;
$after_the_data = <<<eoquinePhp
\$the_data = quine(\$before_the_hs) . ";\\n\\\$before_the_data = " . quine(\$before_the_data) . ";\\n\\\$after_the_data = " . quine(\$after_the_data) . ";\\n";
if (array_key_exists(1, \$argv) && \$argv[1] == 'php')
	echo \$before_the_hs, \$the_hs, \$before_the_data, \$the_data, \$after_the_data;
elseif (array_key_exists(1, \$argv) && \$argv[1] == 'hs')
	echo \$the_hs;
elseif (array_key_exists(1, \$argv) && \$argv[1] == 'cabal')
	echo <<<cabal
Name:          quine
Build-Type:    Simple
Version:       0.0
Cabal-Version: >=1.2

Executable quine
   Main-is:          hs.hs
   Build-Depends:    base>=3, MissingH
   Ghc-options:       -Wall

cabal;
else
	echo "try php, hs or cabal
";

eoquinePhp
;
$the_data = quine($before_the_hs) . ";\n\$before_the_data = " . quine($before_the_data) . ";\n\$after_the_data = " . quine($after_the_data) . ";\n";
if (array_key_exists(1, $argv) && $argv[1] == 'php')
	echo $before_the_hs, $the_hs, $before_the_data, $the_data, $after_the_data;
elseif (array_key_exists(1, $argv) && $argv[1] == 'hs')
	echo $the_hs;
elseif (array_key_exists(1, $argv) && $argv[1] == 'cabal')
	echo <<<cabal
Name:          quine
Build-Type:    Simple
Version:       0.0
Cabal-Version: >=1.2

Executable quine
   Main-is:          hs.hs
   Build-Depends:    base>=3, MissingH
   Ghc-options:       -Wall

cabal;
else
	echo "try php, hs or cabal
";
