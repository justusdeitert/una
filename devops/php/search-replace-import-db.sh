#!/bin/bash
set -e

if ! command -v wp &> /dev/null; then
    echo "wp-cli could not be found."
    exit 1
fi

if [ ! -f "$DB_IMPORT_FILE" ]; then
    echo "Database dump file '$DB_IMPORT_FILE' does not exist."
    exit 1
fi

echo "Resetting the database..."
wp db reset --yes --allow-root

echo "Importing the database from $DB_IMPORT_FILE..."
wp db import "$DB_IMPORT_FILE" --allow-root

echo "Replacing '$REPLACE_STRING' with '$SEARCH_STRING'..."
wp search-replace "$REPLACE_STRING" "$SEARCH_STRING" --allow-root

echo "Updating siteurl and home options..."
wp option update siteurl "http://$SEARCH_STRING" --allow-root
wp option update home "http://$SEARCH_STRING" --allow-root

echo "Database import completed successfully."