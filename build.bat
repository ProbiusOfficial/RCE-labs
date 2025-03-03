@echo off
setlocal enabledelayedexpansion

for /l %%i in (0, 1, 22) do (
    set dir=Level %%i
    set tag=rce_labs:v%%i
    echo Building !tag! from !dir!
    docker build --pull --rm -f "!dir!\Dockerfile" -t "!tag!" "!dir!"

    if errorlevel 1 (
        echo Error building !tag!
        exit 1
    )
)

echo All images built successfully!
endlocal
pause
