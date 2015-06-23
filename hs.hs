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
	" * ",
	" * @param string $subj",
	" * @return string",
	" */",
	"function quine($subj) {",
	"\treturn \"<<<eoquinePhp\\n\" . str_replace(array('\\\\', \"\\$\", ), array('\\\\\\\\', '\\$', ), $subj) . \"\\neoquinePhp\\n\";",
	"}",
	"",
	"$cabal_file = <<<cabal",
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
	"",
	"/*$hs_before_the_php = *hs-> ++ quinePhp beforeThePhp <-sh*",
	"",
	"function haskellquine() {",
	"\techo $hs_before_the_php;",
	"\techo showlist(1, $php_before_the_hs) . \"\\n\";",
	"\techo $hs_before_the_data;",
	"\techo showlist(1, $php_after_the_data) . \"\\n\";",
	"\techo \"m = unlines \" . *hs-> ++ quinePhp (show (lines m)) <-sh*",
	"}*/",
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
	"\techo $cabal_file",
	"else",
	"\techo \"try php, hs or cabal",
	"\";"
	]
m = unlines ["I","am","happy"]
beforeThePhp = unlines [
		"module Main (main)",
		"where",
		"",
		"import Data.List.Utils",
		"import System.Environment",
		"",
		"showlist :: Show a => Int -> [a] -> String",
		"showlist indent xs = \"[\\n\" ++ listIndent ++ listIndenter xs ++ \"\\n\" ++ listIndent ++ \"]\\n\"",
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
beforeTheData = unlines [
		"phpAfterTheData :: String",
		"phpAfterTheData = unlines "
		]
moreHs = unlines [
		"",
		"quine :: IO()",
		"quine = do"
		]
afterTheData = unlines [
		"\tputStr $ rtrim beforeThePhp",
		"\tputStrLn $ showlist 1 (lines phpBeforeTheHs)",
		"\tputStr (rtrim beforeTheData)",
		"\tputStrLn (showlist 1 (lines phpAfterTheData))",
		"\tputStrLn $ \"m = unlines \" ++ show (lines m)",
		"\tputStrLn $ \"beforeThePhp = unlines \" ++ showlist 1 (lines beforeThePhp)",
		"\tputStrLn $ \"beforeTheData = unlines \" ++ showlist 1 (lines beforeTheData)",
		"\tputStrLn $ \"moreHs = unlines \" ++ showlist 1 (lines moreHs)",
		"\tputStrLn $ \"afterTheData = unlines \" ++ showlist 1 (lines afterTheData)",
		"\tputStr moreHs",
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
		"\tlet phpBeforeTheData1 = \"\\nhs;\\n",
		"\tlet phpBeforeTheData2 = \"$before_the_hs = \"",
		"\tlet theData = quinePhp phpBeforeTheHs ++ \";\\n$before_the_data = \" ++ quinePhp phpBeforeTheData ++ \";\\n$after_the_data = \" ++ quinePhp phpAfterTheData ++ \";\\n\"",
		"\tputStr phpBeforeTheHs",
		"\tquine",
		"\tputStr phpBeforeTheData1",
		"\tputStr phpBeforeTheData2",
		"\tputStr theData",
		"\tputStr phpAfterTheData",
		"makeOutput _ = quine",
		"",
		"main :: IO()",
		"main = getArgs >>= makeOutput"
		]

quine :: IO()
quine = do
	putStr $ rtrim beforeThePhp
	putStrLn $ showlist 1 (lines phpBeforeTheHs)
	putStr (rtrim beforeTheData)
	putStrLn (showlist 1 (lines phpAfterTheData))
	putStrLn $ "m = unlines " ++ show (lines m)
	putStrLn $ "beforeThePhp = unlines " ++ showlist 2 (lines beforeThePhp)
	putStrLn $ "beforeTheData = unlines " ++ showlist 2 (lines beforeTheData)
	putStrLn $ "moreHs = unlines " ++ showlist 2 (lines moreHs)
	putStrLn $ "afterTheData = unlines " ++ showlist 2 (lines afterTheData)
	putStr moreHs
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

