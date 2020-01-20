@echo off

SET jscompress=java -jar ./gcc/closure-compiler-v20181125.jar
SET built=./build

echo %jscompress%

REM raw js file path
SET linq="%built%/linq.js"
SET pakchoi="%built%/pakchoi.js"

echo "Do script minify compression..."

%jscompress% --js %linq% --js_output_file "%built%/linq.min.js"
echo .
%jscompress% --js %pakchoi% --js_output_file "%built%/pakchoi.min.js"

echo "[job done!]"