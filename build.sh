#!/bin/bash

for i in {0..27}; do
    dir="Level ${i}"
    tag="rce_labs:v${i}"
    echo "Building $tag from $dir"
    docker build --pull --rm -f "${dir}/Dockerfile" -t "${tag}" "${dir}"
    
    if [ $? -ne 0 ]; then
        echo "Error building $tag"
        exit 1
    fi
done

echo "All images built successfully!"
