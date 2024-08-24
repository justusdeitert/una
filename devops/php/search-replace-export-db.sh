#!/bin/bash

# Ensure the wp-cli is installed and available
if ! command -v wp &> /dev/null; then
    echo "wp-cli could not be found. Please install it first."
    exit 1
fi

# Export the database with search-replace
echo "Exporting the database to $DB_EXPORT_FILE with replacements..."
wp search-replace "$SEARCH_STRING" "$REPLACE_STRING" --export="$DB_EXPORT_FILE" --allow-root

# Confirm completion
if [ -f "$DB_EXPORT_FILE" ]; then
    echo "Database dump completed successfully. The file is saved as $DB_EXPORT_FILE."
else
    echo "Database dump failed. Please check for errors."
    exit 1
fi
