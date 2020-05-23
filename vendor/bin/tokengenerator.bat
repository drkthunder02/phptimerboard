@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../eveseat/eseye/bin/tokengenerator
bash "%BIN_TARGET%" %*
