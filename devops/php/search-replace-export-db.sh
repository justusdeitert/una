#!/bin/bash
set -e

if ! command -v wp &> /dev/null; then
    echo "wp-cli could not be found."
    exit 1
fi

echo "Exporting the database to $DB_EXPORT_FILE..."
wp search-replace "$SEARCH_STRING" "$REPLACE_STRING" --export="$DB_EXPORT_FILE" --allow-root

if [ -f "$DB_EXPORT_FILE" ]; then
    echo "Database export completed successfully: $DB_EXPORT_FILE"
else
    echo "Database export failed."
    exit 1
fi
