#!/bin/bash

jscompress=`printf "java -jar ./gcc/closure-compiler-v20181125.jar"`
built=`printf "./build"`

echo $jscompress
echo "build location is: $built"

# raw js file path
linq=`printf "%s/linq.js" $built`
pakchoi=`printf "%s/pakchoi.js" $built`

echo "Do script minify compression..."

linq="$jscompress --js $linq --js_output_file $built/linq.min.js"
pakchoi="$jscompress --js $pakchoi --js_output_file $built/pakchoi.min.js"

echo "RUN: $linq"
$linq

echo "RUN: $pakchoi"
$pakchoi

echo "[job done!]"