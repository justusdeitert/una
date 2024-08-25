#!/bin/bash

# Ensure the wp-cli is installed and available
if ! command -v wp &> /dev/null; then
    echo "wp-cli could not be found. Please install it first."
    exit 1
fi

# Check if the database dump file exists
if [ ! -f "$DB_IMPORT_FILE" ]; then
    echo "Database dump file '$DB_IMPORT_FILE' does not exist. Please provide a valid file."
    exit 1
fi

# Reset the current database to remove old data
echo "Resetting the database..."
wp db reset --yes --allow-root

# Check if reset was successful
if [ $? -ne 0 ]; then
    echo "Database reset failed. Please check for errors."
    exit 1
fi

# Import the SQL dump file into the database
echo "Importing the database from $DB_IMPORT_FILE..."
wp db import "$DB_IMPORT_FILE" --allow-root

# Confirm completion
if [ $? -eq 0 ]; then
    echo "Database import completed successfully."
else
    echo "Database import failed. Please check for errors."
    exit 1
fi

# Perform search-replace on the imported database
wp search-replace "$REPLACE_STRING" "$SEARCH_STRING" --allow-root

# Check if search-replace was successful
if [ $? -eq 0 ]; then
    echo "Search-replace operation completed successfully."
else
    echo "Search-replace operation failed. Please check for errors."
    exit 1
fi

# NOTE: Not necessary if the site URL is already correct
echo "Updating WordPress Address (URL) and Site Address (URL) to $NEW_URL..."
wp option update siteurl "http://$SEARCH_STRING" --allow-root

if [ $? -eq 0 ]; then
    echo "WordPress Address (URL) updated successfully to http://$SEARCH_STRING"
else
    echo "Failed to update WordPress Address (URL). Please check for errors."
    exit 1
fi