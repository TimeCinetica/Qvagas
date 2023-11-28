#!/bin/bash

#php artisan scribe:generate --force &&
npm run production &&
git add . && 
git commit -m "chore(docs): generate new static files" &&
npm run release &&
git push --follow-tags origin master &&
npm run build:hostinger
