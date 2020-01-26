#!/bin/bashß

jscompress=`printf "java -jar ./gcc/closure-compiler-v20181125.jar"`
built=`printf "./build"`

echo $jscompress

# raw js file path
linq=`printf "%s/linq.js" $built`
pakchoi=`printf "%s/pakchoi.js" $built`

echo "Do script minify compression..."

`printf "%s --js %s --js_output_file %s/linq.min.js" $jscompress $linq $built`
`printf "%s --js %s --js_output_file %s/pakchoi.min.js" $jscompress $pakchoi $built`

echo "[job done!]"