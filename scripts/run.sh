#!/bin/bash

case "$1" in
  start)
    echo -e "Starting services...\n"
    docker compose up -d
    symfony server:start -d
    npm run dev &
    ;;
  stop)
    echo -e "Stopping services...\n"
    docker compose down
    symfony server:stop
    pkill -f "npm run dev"
    ;;
  *)
    echo "Usage: $0 {start|stop}"
    ;;
esac
